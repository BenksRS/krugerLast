<?php

namespace Modules\Integration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kreait\Firebase\Database;
use Modules\Integration\Entities\IntegrationFailedJob;
use Modules\Integration\Services\Firebase\DatabaseService;

class Manager {

    /**
     * @var null
     */
    public mixed                $connections;

    public IntegrationFailedJob $failedJob;

    protected Database          $database;

    protected                   $limit;

    /**
     * @param                 $connections
     * @param DatabaseService $database
     */
    public function __construct ($connections = NULL)
    {
        $this->connections = $connections;
        $this->database    = app(Database::class);
        $this->failedJob   = app(IntegrationFailedJob::class);

        $this->limit = config('integration.queries.limit');
    }

    protected function getConfig ($connection)
    {
        return config('integration.connection.' . $connection);
    }

    public function set ($id = NULL)
    {
        if ( !$this->connections ) {
            return;
        }

        if ( $id ) {
            $connection = is_array($this->connections) ? $this->connections[0] : $this->connections;
            $this->hasSync($connection, $id);
        } else {
            if ( is_array($this->connections) ) {
                foreach ( $this->connections as $connection ) {
                    $this->hasNotSynced($connection);
                }
            } else {
                $this->hasNotSynced($this->connections);
            }
        }
    }

    public function get ()
    {
        if ( !$this->connections ) {
            return;
        }

        $connection = is_array($this->connections) ? $this->connections[0] : $this->connections;

        $config = $this->getConfig($connection);

        $model  = app($config['model']);
        $events = $config['events'];
        $rules  = $config['rules'] ?? [];

        $reference = $this->database->getReference($config['table']);

        $items = $reference->getValue();

        if ( $items ) {
            foreach ( $items as $key => $item ) {

                if ( empty($item['job_id']) ) {
                    continue;
                }

                $resources = $model->setData($item);
                $dot       = Arr::dot($item);

                dump($events);

                if ( $events ) {
                    foreach ( $events as $event ) {
                        switch ( $event ) {
                            case 'local.create':
                                $model->create($resources);
                            break;
                            case 'local.update':

                                if ( !empty($rules) ) {
                                    foreach ( $rules[$event] as $rule => $status ) {
                                        if ( in_array($dot[$rule], $status) ) {
                                            $model->find($item['job_id'])->update($resources);
                                        }
                                    }
                                } else {
                                    $model->find($item['job_id'])->update($resources);
                                }

                                if ( (isset($item['sync_delete']) && $item['sync_delete'] === TRUE) ||
                                     (isset($item['status']['new']) && $item['status']['new'] == 'uploading_pics') ) {
                                    $reference->getChild($key)->remove();
                                }
                            break;
                            case 'remote.delete':

                                if ( !empty($rules) ) {
                                    foreach ( $rules[$event] as $rule => $status ) {
                                        if ( in_array($dot[$rule], $status) ) {
                                            $reference->getChild($key)->remove();
                                        }
                                    }
                                } else {
                                    $reference->getChild($key)->remove();
                                }


                            break;
                        }
                    }

                    if ( !empty($config['relations']) ) {
                        foreach ( $config['relations'] as $relation ) {
                            $relationModel     = app($relation);
                            $relationResources = $relationModel->setData($item);
                            $relationModel->upsert($relationResources, []);
                        }

                    }

                }
            }
        }

    }

    /**
     * @param $connection
     * @param $id
     *
     * @return void
     */
    protected function hasSync ($connection, $id)
    {
        $config = $this->getConfig($connection);

        $model = app($config['model']);
        $item  = $model->find($id);

        $reference = $this->database->getReference($config['table']);
        $resources = $item->getData();
        if ( empty($item->sync) ) {

            try {

                $data = $reference->push($resources);
                $key  = $data->getKey();

                $item->sync()->create(['uuid' => $key]);

            } catch ( \Exception $e ) {
                $this->failedJob->create([
                    'queue'     => $connection,
                    'payload'   => $resources,
                    'exception' => $e->getMessage(),
                ]);
            }
        } else {
            $key  = $item->sync->uuid;
            $data = $reference->getChild($key);

            if ( isset($resources['sync_delete']) && $resources['sync_delete'] === TRUE ) {
                $data->remove();
            } else {
                $data->update($resources);
            }
        }
    }

    /**
     * @param $connection
     *
     * @return void
     */
    protected function hasNotSynced ($connection)
    {
        $config = $this->getConfig($connection);

        $model = app($config['model']);
        $items = $model->notSynced()->get();

        $reference = $this->database->getReference($config['table']);

        foreach ( $items as $item ) {
            $resources = $item->getData();

            try {
                $data = $reference->push($resources);
                $key  = $data->getKey();

                $item->sync()->create(['uuid' => $key]);

            } catch ( \Exception $e ) {
                $this->failedJob->create([
                    'queue'     => $connection,
                    'payload'   => $resources,
                    'exception' => $e->getMessage(),
                ]);
            }
        }
    }

    public function getTest ()
    {
        if ( !$this->connections ) {
            return;
        }

        $connection = is_array($this->connections) ? $this->connections[0] : $this->connections;

        $config = $this->getConfig($connection);

        $model  = $this->newModel($config['model']);
        $events = $config['events'];
        $rules  = $config['rules'] ?? [];

        $reference = $this->database->getReference($config['table']);

        $items = $reference->orderByKey()->limitToFirst(2)->getValue();

        /*        dump(
                    collect($items)->whereIn('status.new', ['uploading_pics', 'in_progress'])->where('sync_delete', FALSE)->lazy()->toArray());*/

        $aa = collect($events)->flatMap(function ($event) use ($items, $config) {
            $collection = collect($items);
            $rules      = $config['rules'][$event] ?? [];
            if ( $rules ) {
                foreach ( $rules as $rule => $status ) {
                    $collection = is_array($status) ? $collection->whereIn($rule, $status) : $collection->where($rule, $status);
                }
            }

            return [$event => $collection->lazy()->all()];
        })->each(function ($items, $event) use ($model, $reference) {

            foreach ( $items as $item ) {
                $resources = $model->setData($item);
                $dot       = Arr::dot($item);

                switch ( $event ) {
                    case 'local.create':
                        dump('local.create', $item['job_id']);
                    break;
                    case 'local.update':
                        dump('local.update', $item['job_id']);
                    break;
                    case 'local.delete':
                        dump('local.delete', $item['job_id']);
                    break;
                    case 'remote.create':
                        dump('remote.create', $item['job_id']);
                    break;
                    case 'remote.update':
                        dump('remote.update', $item['job_id']);
                    break;
                    case 'remote.delete':
                        dump('remote.delete', $item['job_id']);
                    break;
                }

                /*                switch ( $event ) {
                                    case 'local.create':
                                        $model->create($resources);
                                    break;
                                    case 'local.update':
                                        if ( isset($rules) ) {
                                            foreach ( $rules[$event] as $rule => $status ) {
                                                if ( in_array($dot[$rule], $status) ) {
                                                    $model->find($item['job_id'])->update($resources);
                                                }
                                            }
                                        } else {
                                            $model->find($item['job_id'])->update($resources);
                                        }
                                        if ( (isset($item['sync_delete']) && $item['sync_delete'] === TRUE) ||
                                             (isset($item['status']['new']) && $item['status']['new'] == 'uploading_pics') ) {
                                            $reference->getChild($item['job_id'])->remove();
                                        }
                                    break;
                                    case 'remote.delete':
                                        $reference->getChild($item['job_id'])->remove();
                                    break;
                                }*/
            }

        });

        return;

        if ( $items ) {
            foreach ( $items as $key => $item ) {
                $resources = $model->setData($item);
                $dot       = Arr::dot($item);

                dump($events);

                if ( $events ) {
                    foreach ( $events as $event ) {
                        switch ( $event ) {
                            case 'local.create':
                                $model->create($resources);
                            break;
                            case 'local.update':
                                if ( isset($rules) ) {
                                    foreach ( $rules[$event] as $rule => $status ) {
                                        if ( in_array($dot[$rule], $status) ) {
                                            $model->find($item['job_id'])->update($resources);
                                        }
                                    }
                                } else {
                                    $model->find($item['job_id'])->update($resources);
                                }

                                if ( (isset($item['sync_delete']) && $item['sync_delete'] === TRUE) ||
                                     (isset($item['status']['new']) && $item['status']['new'] == 'uploading_pics') ) {
                                    $reference->getChild($key)->remove();
                                }
                            break;
                            case 'remote.delete':
                                $reference->getChild($key)->remove();
                            break;
                        }
                    }

                    if ( !empty($config['relations']) ) {
                        foreach ( $config['relations'] as $relation ) {
                            $relationModel     = app($relation);
                            $relationResources = $relationModel->setData($item);
                            $relationModel->upsert($relationResources, []);
                        }

                    }

                }
            }
        }

    }

    /**
     * @param $model
     *
     * @return Model
     */
    protected function newModel ($model): Model
    {
        return app($model);
    }

}