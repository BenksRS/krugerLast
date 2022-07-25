<?php

namespace Modules\Integration;

use Modules\Integration\Services\Firebase\DatabaseService;

class Manager {

    public DatabaseService $service;

    public function __construct (DatabaseService $service)
    {
        $this->service = $service;
    }

    public function sync ($connection, $id, $delete = false)
    {
        $config = config('integration.connection.' . $connection);

        $model = app($config['model']);

        $item = $model->find($id);

        if ( $item ) {
            $resource  = $item->resources();
            $reference = $this->service->reference($config['database']);

            if ( empty($item->sync) ) {
                $child = $reference->push($resource);
                $key   = $child->getKey();
                if ( $key ) {
                    $item->sync()->create(['uuid' => $key]);
                }
            } else {
                $key   = $item->sync->uuid;
                $child = $reference->child($key);

                if ( $delete === TRUE ) {
                    $child->remove();
                } else {
                    $child->update($resource);
                }
            }
        }
    }

}