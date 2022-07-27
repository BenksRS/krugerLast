<?php

namespace Modules\Integration;

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

    /**
     * @param                 $connections
     * @param DatabaseService $database
     */
    public function __construct ($connections = NULL)
    {
        $this->connections = $connections;
        $this->database    = app(Database::class);
        $this->failedJob   = app(IntegrationFailedJob::class);
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
                $resources = $model->setData($item);
                $dot       = Arr::dot($item);

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
                            break;
                            case 'remote.delete':
                                $reference->getChild($key)->remove();
                            break;
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

}