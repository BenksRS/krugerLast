<?php

namespace Callkruger\Api\Handlers\Listeners\Firebase;

use Callkruger\Api\Handlers\Events\DataSync;
use Kreait\Firebase\Database;
use Kreait\Firebase\Exception\DatabaseException;
use ReflectionClass;
use ReflectionException;

class FirebaseSync {

    /** Actions  */
    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const DELETE = 'delete';

    /**
     * @var Database
     */
    protected $firebase;

    /**
     * @var DataSync
     */
    protected $event;

    /**
     * FirebaseSync constructor.
     *
     * @param Database $firebase
     */
    public function __construct (Database $firebase)
    {
        $this->firebase = $firebase;
    }

    /**
     * @param DataSync $event
     */
    public function handle (DataSync $event)
    {
        $this->event = $event;

        switch ( $this->event->resource['event'] ) {
            case 'sync':

                if ( !empty($this->event->resource['provider']) ) {
                    $this->sync();
                } else {
                    $this->syncAll();
                }

            break;
            case 'retrieve':
                $this->retrieve();
            break;
            case 'subscribe':
                $this->subscribe();
            break;
        }
    }

    protected function sync ()
    {
        $provider = $this->event->providers->get($this->event->resource['provider']);
        $uid      = $this->event->resource['uid'];
        $delete   = $this->event->resource['delete'];

        $data = $this->event->collections($provider);
        try {
            $model = new ReflectionClass($data['model']);
            $model = $model->newInstanceArgs();

            $item = $model->with(['sync'])->find($uid);

            if ( $item ) {

                try {
                    $reference = $this->firebase->getReference($data['table']);
                    /*                $resource  = ApiResource::custom($item, $data['attributes'])->first();*/
                    $resource = $item->resource();

                    /// Verifica se o item não foi sincronizado
                    if ( empty($item->sync) ) {
                        $child = $reference->push($resource);
                        $apiId = $child->getKey();
                        if ( $apiId ) {
                            $item->sync()->create(['driver' => 'firebase', 'data_key' => $apiId]);
                        }
                    } else {
                        $apiId = $item->sync->data_key;
                        $child = $reference->getChild($apiId);

                        if ( $delete === TRUE ) {
                            $child->remove();
                        } else {
                            $child->update($resource);
                        }
                    }
                } catch ( DatabaseException $e ) {
                    echo $e->getMessage();
                }
            }
        } catch ( ReflectionException $e ) {
            echo $e->getMessage();
        }
    }

    protected function syncaaa ()
    {
        $provider = $this->event->providers->get($this->event->resource['provider']);
        $uid      = $this->event->resource['uid'];
        $delete   = $this->event->resource['delete'];

        $data = $this->event->collections($provider);

        $connectionLocal   = data_get($provider, 'connections.local');
        $connectionNetwork = data_get($provider, 'connections.network');

        $tableLocal   = data_get($connectionLocal, 'table');
        $tableNetwork = data_get($connectionNetwork, 'table');

        $indexNetwork = data_get($connectionNetwork, 'index') ?? 'id';

        $actionsNetwork = collect(data_get($connectionNetwork, 'actions'))->all();

        try {
            $model = new ReflectionClass(data_get($provider, 'model'));
            $model = $model->newInstanceArgs();

            // Service Data
            $item = $model->with('sync')->find($uid);

            if ( $item ) {
                try {

                    // Service Sync relationship
                    $sync = $item->sync;

                    // Firebase Reference
                    $reference = $this->firebase->getReference($tableNetwork);
                    $filter    = $reference;

                    // Firebase indexes
                    if ( $indexNetwork ) {
                        $filter = $reference->orderByChild($indexNetwork)->equalTo($uid);
                    }

                    // Firebase ApiID
                    $apiId = collect($filter->getValue())->keys()->first();
                    $apiId = $apiId ?? $reference->push()->getKey();

                    switch ( (boolean) $sync ) {
                        case 0:
                            $item->sync()->create(['driver' => 'firebase', 'data_key' => $apiId]);
                        break;
                        case 1:
                            // Sync ApiID
                            $apiId = $sync->data_key;
                        break;
                    }

                    // Service Resource
                    $resource = $delete ? [] : $item->resource();

                    // Update or Delete Firebase Data
                    $reference->update([$apiId => $resource]);

                    dump($resource);
                } catch ( DatabaseException $e ) {
                }
            }
        } catch ( ReflectionException $e ) {
        }

        return;

        try {
            $model = new ReflectionClass($data['model']);
            $model = $model->newInstanceArgs();

            $item = $model->find($uid);

            if ( $item ) {

                try {
                    $reference = $this->firebase->getReference($data['table']);
                    /*                $resource  = ApiResource::custom($item, $data['attributes'])->first();*/
                    $resource = $item->resource();
                    $sync     = $item->load('sync')->sync;

                    switch ( (boolean) $sync ) {
                        case 0:
                            $child = $reference->push($resource);
                            $apiId = $child->getKey();
                            if ( $apiId ) {
                                $item->sync()->create(['driver' => 'firebase', 'data_key' => $apiId]);
                            }
                        break;
                        case 1:
                            $child = $reference->getChild($sync->data_key);

                            if ( $delete == TRUE ) {
                                $child->remove();
                            } else {
                                $child->update($resource);
                            }
                        break;
                    }

                    return;
                    /// Verifica se o item não foi sincronizado
                    if ( empty($item->sync) ) {

                    } else {
                        $apiId = $item->sync->data_key;
                        $child = $reference->getChild($apiId);
                    }
                } catch ( DatabaseException $e ) {
                    echo $e->getMessage();
                }
            }
        } catch ( ReflectionException $e ) {
            echo $e->getMessage();
        }
    }

    protected function syncAll ()
    {
        $this->event->actions()->each(function ($provider) {

            $data = $this->event->collections($provider);
            try {

                $model = new ReflectionClass($data['model']);
                $model = $model->newInstanceArgs();

                $items = $model->NotSynced()->get();

                if ( $items ) {

                    $reference = $this->firebase->getReference($data['table']);

                    foreach ( $items as $item ) {
                        /*                    $resource = ApiResource::custom($item, $data['attributes'])->first();*/
                        $resource = $item->resource();
                        try {
                            $push = $reference->push($resource);
                            $key  = $push->getKey();

                            if ( $key ) {
                                $item->sync()->create(['driver' => 'firebase', 'data_key' => $key]);
                            }
                        } catch ( DatabaseException $e ) {
                            echo $e->getMessage();
                        }
                    }
                }
            } catch ( ReflectionException $e ) {
                echo $e->getMessage();
            }
        });
    }

    protected function subscribe ()
    {

        $providers = $this->event->providers;
        $providers = $providers->only(['jobs']);

        try {
            $reference = $this->firebase->getReference('jobs')->orderByChild('_sync')->equalTo(TRUE);

            /*            dump($reference->shallow()->getValue());*/
            dump($reference->getSnapshot()->hasChildren());

            /*            dump($reference->shallow()->getReference()->getChild('jobs')->getChildKeys());*/

            return;

            if ( $snapshot->exists() ) {
                collect($snapshot->getValue())->each(function ($subscribe, $name) use ($providers) {

                    $apiIds  = collect($subscribe)->pluck('api_id');
                    $dbItems = $this->firebase->getReference($name)->orderByKey()->limitToFirst(1);

                    $syncItems = $apiIds->mapWithKeys(function ($apiId) use ($dbItems) {
                        return $dbItems->equalTo($apiId)->getValue();
                    });
                    dump($syncItems);
                    /*                   $providerItems = collect($this->firebase->getReference($name)->getValue())->only($apiIds);*/
                    /*                    $providerItems = collect($this->firebase->getReference($name)->getValue())->filter(function ($v, $i) use ($subscribe) {
                                            return in_array($i, array_keys($subscribe));
                                        });
                                        dump($providerItems);*/
                });
            }
            /*            $providers->each(function ($provider, $name) use ($subscribe) {
                            $items = $this->firebase->getReference($name)->getValue();
                            $keys  = collect($subscribe[$name])->keys();

                            dump(collect($items)->filter(function ($v, $i) use ($keys) {
                                return $keys->contains($i);
                            }));
                        });*/
        } catch ( DatabaseException $e ) {
            echo $e->getMessage();
        }
    }

    protected function retrieveTest ()
    {
        /// Verifica se existe apenas uma ação local
        if ( count($actionsLocal) == 1 ) {
            $actionLocalName   = array_keys($actionsLocal)[0];
            $actionLocalStatus = array_values($actionsLocal)[0];

            if ( $actionLocalStatus == TRUE ) {

                /// Verifica se existe clausulas adicionais
                if ( !empty($clauses[$actionLocalName]) ) {
                    $fields = $clauses[$actionLocalName];

                    /// Verifica quais campos possuem clausulas adicionais
                    $data->each(function ($value, $name) use ($fieldsStatus, $fields) {
                        if ( !empty($fields[$name]) ) {
                            $fieldsStatus[$name] = collect($fields[$name])->contains($value);
                        }
                    });

                    /// Verifica se existe campos com status FALSE
                    $clauseStatus = !$fieldsStatus->contains(FALSE);
                    /*                        $clause = $data->contains(function ($value, $name) use ($fields) {
                                                return !empty($fields[$name]) && collect($fields[$name])->contains($value);
                                            });*/
                }

                dump($clauseStatus);

                if ( $clauseStatus ) {
                    switch ( $actionLocalName ) {
                        case 'create':
                            $store = $model->actionTable()->updateOrCreate($filter, $data->all());
                        break;
                        case 'update':
                            $store = $model->actionTable()->where($filter)->first();
                            $store->update($data->all());
                        break;
                    }

                    if ( !empty($store) ) {
                        $store->relationships($resource);
                    }
                }
            }
            dd('teste');
        }
    }

    protected function retrieve2 ()
    {
        $providers = $this->event->providers;
        $providers = $providers->only(['jobs']);

        $providers->each(function ($provider, $name) {

            $connections = data_get($provider, 'connections');

            /// Model attributes
            $keys = data_get($provider, 'keys');

            $clauses = data_get($provider, 'clauses');

            /// Tables
            $networkTable = data_get($connections, 'network.table');

            /// Actions
            $localActions   = collect(data_get($connections, 'local.actions'))->filter()->keys();
            $networkActions = collect(data_get($connections, 'network.actions'))->filter()->keys();

            if ( $localActions->count() ) {

                if ( $localActions->count() == 1 ) {
                    dump($localActions->first());
                }

                try {
                    $reference = $this->firebase->getReference($networkTable);
                    $reference = $reference->orderByKey()->limitToFirst(100);
                    $snapshot  = $reference->getSnapshot();

                    if ( $snapshot->exists() ) {

                        /// Model instance
                        $model = new_instance(data_get($provider, 'model'));

                        foreach ( $snapshot->getValue() as $apiId => $item ) {

                            $resource = collect($item)->serialize($provider, 'network');
                            dump($resource);
                        };
                    }
                } catch ( DatabaseException $e ) {
                }
            }
        });
    }

    protected function retrieve ()
    {
        $this->event->providers->each(function ($provider, $name) {

            $connectionLocal   = data_get($provider, 'connections.local');
            $connectionNetwork = data_get($provider, 'connections.network');

            $actionsLocal   = collect(data_get($connectionLocal, 'actions'))->only(['create', 'update'])->all();
            $actionsNetwork = collect(data_get($connectionNetwork, 'actions'))->all();

            $tableLocal   = data_get($connectionLocal, 'table');
            $tableNetwork = data_get($connectionNetwork, 'table');

            if ( $actionsLocal ) {

                try {
                    $aliases = data_get($provider, 'aliases');
                    $keys    = data_get($provider, 'keys');
                    $clauses = data_get($provider, 'clauses');

                    $model = new ReflectionClass(data_get($provider, 'model'));
                    $model = $model->newInstanceArgs();

                    /// Firebase
                    $reference = $this->firebase->getReference($tableNetwork);
                    /*                  $filter    = $reference->orderByChild('server_event')->equalTo('done');*/
                    /*                    $filter    = $reference->orderByKey()->limitToFirst(10);*/
                    $items = $reference->getValue();

                    if ( $items ) {
                        foreach ( $items as $key => $item ) {
                            $resource = collect($item)->serialize($provider, 'network');

                            /// Transform
                            $resource = collect($resource)->transform(function ($value, $name) use ($aliases) {
                                $key = $aliases[$name] ?? $name;

                                return [$key => $value];
                            })->collapse();

                            $filter = $resource->only($keys)->all();
                            $data   = $resource->except($keys);

                            if ( count($actionsLocal) == 1 ) {
                                if ( !empty($actionsLocal['create']) && $actionsLocal['create'] == TRUE ) {
                                    $store = $model->actionTable()->updateOrCreate($filter, $data->all());
                                    if ( $store ) {
                                        $store->relationships($resource);
                                    }
                                }

                                if ( !empty($actionsLocal['update']) && $actionsLocal['update'] == TRUE ) {

                                    $clause = $data->contains(function ($value, $name) use ($clauses) {

                                        if ( !empty($clauses['update']) ) {
                                            return !empty($clauses['update'][$name]) && collect($clauses['update'][$name])->contains($value);
                                        }

                                        return TRUE;
                                    });
                                    if ( $clause ) {
                                        $store = $model->actionTable()->where($filter)->first();
                                        if ( $store ) {
                                            $store->update($data->all());
                                            $store->relationships($resource);
                                        }
                                    }
                                }
                            } else if ( count($actionsLocal) > 1 ) {
                                if ( (!empty($actionsLocal['create']) && $actionsLocal['create'] == TRUE) || (!empty($actionsLocal['update']) && $actionsLocal['update'] == TRUE) ) {
                                    $store = $model->actionTable()->updateOrCreate($filter, $data->all());
                                    if ( $store ) {
                                        $store->relationships($resource);
                                    }
                                }
                            }

                            if ( !empty($actionsNetwork['delete']) && $actionsNetwork['delete'] == TRUE ) {
                                $clause = $data->contains(function ($value, $name) use ($clauses) {

                                    if ( !empty($clauses['delete']) ) {
                                        return !empty($clauses['delete'][$name]) && collect($clauses['delete'][$name])->contains($value);
                                    }

                                    return TRUE;
                                });
                                if ( $clause ) {
                                    $reference->getChild($key)->remove();
                                }
                            }
                        }
                    }
                } catch ( ReflectionException $e ) {
                    echo $e->getMessage();
                } catch ( DatabaseException $e ) {
                    echo $e->getMessage();
                }
            }
            /*            if ( $actions ) {
                            try {
                                $model = new ReflectionClass(data_get($provider, 'model'));
                                $model = $model->newInstanceArgs();

                                $connection = data_get($provider, 'connections.network');

                                $reference = $this->firebase->getReference(data_get($connection, 'table'));
                                $filter = $reference;
                                $items  = $filter->getValue();

                                $aliases = data_get($provider, 'aliases');
                                $keys    = data_get($provider, 'keys');
                                $clauses = data_get($provider, 'clauses');

                                if ( $items ) {

                                    foreach ( $items as $key => $item ) {

                                        $resource = collect($item)->serialize($provider, 'network');
                                        $resource = collect($resource)->transform(function ($value, $name) use ($aliases) {
                                            $key = $aliases[$name] ?? $name;

                                            return [$key => $value];
                                        })->collapse()->all();

                                        $filter = collect($resource)->only($keys)->all();
                                        $data   = collect($resource)->except($keys)->filter(function ($value, $name) use (
                                            $clauses
                                        ) {
                                            if ( $clauses && !empty($clauses['update'][$name]) ) {
                                                $collection = Collection::wrap($clauses['update'][$name]);

                                                return $collection->contains($value);
                                            }

                                            return TRUE;
                                        })->all();
                                        if ( $data ) {
                                            try {
                                                $store = $model->actionTable()->updateOrCreate($filter, $data);
                                                if ( $store ) {
                                                    $store->relationships($resource);
                                                }

                                                $check = collect($store)->filter(function ($value, $name) use (
                                                    $clauses
                                                ) {
                                                    if ( $clauses && !empty($clauses['delete'][$name]) ) {
                                                        $collection = Collection::wrap($clauses['delete'][$name]);

                                                        return $collection->contains($value);
                                                    }
                                                })->all();

                                                if ( data_get($connection, 'actions.delete') === TRUE ) {
                                                    if ( !empty($clauses['delete']) ) {
                                                        if ( $check ) {
                                                            $reference->getChild($key)->remove();
                                                        }
                                                    } else {
                                                        $reference->getChild($key)->remove();
                                                    }
                                                } else {
                                                    $reference->getChild($key)->update(['server_event' => 'done']);
                                                }
                                            } catch ( \Exception $exception ) {
                                                echo PHP_EOL, $exception->getMessage(), PHP_EOL, PHP_EOL;
                                            }
                                        }
                                    }
                                }
                            } catch ( ReflectionException $e ) {
                                echo $e->getMessage();
                            }
                        }*/
        });
    }

    protected function data ()
    {
        return [
            "id"       => 1,
            "job_id"   => 6453,
            "job_type" => 2,
            "report"   => [
                "checklist"      => [
                    ["name" => "height_accommodation", "value" => 'Y'],
                    ["name" => "tarp_alterations", "value" => 'N'],
                ],
                "elements"       => [
                    "infos"    => "Teste",
                    "sandbags" => "203",
                ],
                "report_options" => [13, 3, 16],
                "tarp_size"      => [
                    ["height" => "34", "quantity" => "1", "stock" => 1, "width" => "450"],
                    ["height" => "2", "quantity" => "3", "stock" => 4, "width" => "1"],
                ],
                "workers"        => [7, 15],
            ],
        ];
    }

}
