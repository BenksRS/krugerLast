<?php

namespace Callkruger\Api\Handlers\Listeners;

use Callkruger\Api\Handlers\Events\DataSync;
use Kreait\Firebase\Database;

class SharedData {

    /**
     * @var Database
     */
    public $database;

    public function __construct (Database $database)
    {
        $this->database = $database;
    }

    public function handle (DataSync $event)
    {
        $config = api_provider($event->provider);
        $model  = app($config['model']);

        $tables = $config['tables'];
        $table  = $tables['firebase'] ?? class_name($model);

        $item = $model->find($event->id);

        if($item){
            $data = $item->apiResource($item)->jsonSerialize();
            $sync = $item->sync();

            $database = $this->database->getReference($table);

            if ( $sync->count() === 0 ) {
                $response = $database->push($data);

                if($response->getKey()) {
                    $sync->firstOrCreate([], ['driver' => 'firebase', 'data_key' => $response->getKey()]);
                }
            }else{

                $response = $database->getChild($sync->first()->data_key);

                if($event->delete){
                    $response->remove();
                    $sync->delete();
                }else{
                    $response->update($data);
                }
            }

        }



        /*        $modelName = class_name($event->model);
                $tableName = $event->model->getTableConnection('firebase');

                $data = $event->model->apiResource($event->model)->jsonSerialize();
                $sync = $event->model->sync();

                if ( $sync->count() === 0 ) {
                    $database = $this->database->getReference($tableName)->push($data);

                    $sync->firstOrCreate([], ['driver' => 'firebase', 'data_key' => $database->getKey()]);
                }*/
    }

}
