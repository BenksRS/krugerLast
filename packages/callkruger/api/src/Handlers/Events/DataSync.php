<?php

namespace Callkruger\Api\Handlers\Events;

use Illuminate\Queue\SerializesModels;

class DataSync {

    use SerializesModels;

    public $providers;

    public $resource;

    public $connection;

    public function __construct (array $resource = [])
    {
        $this->providers  = collect(config('callkruger-api.providers'));
        $this->resource   = $resource;
        $this->connection = $this->resource['connection'] ?? 'local';
    }

    public function actions ()
    {
        return $this->providers->filter(function ($provider) {
            $actions = api_connections($provider, $this->connection, TRUE);

            return !empty($actions['create']);
        });
    }

    public function collections ($provider, $connection = null)
    {
        $data = api_connections($provider, $connection ?? $this->connection);

        $table      = data_get($data, 'table');
        $attributes = data_get($provider, 'attributes');

        $model = data_get($provider, 'model');

        return compact('connection', 'table', 'attributes', 'model');
    }

}
