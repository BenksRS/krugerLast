<?php

namespace Callkruger\Api\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class ApiModel extends Model {

    use \Awobaz\Compoships\Compoships;

    /*    protected $with = ['sync'];*/

    public    $shared;

    protected $providerModel;

    protected $providerConnection;

    public function __construct (array $attributes = [])
    {
        parent::__construct($attributes);
        $this->providerModel      = $this->getProvider();
        $this->providerConnection = api_connections($this->providerModel);
        $this->providerTable();
    }

    protected function providerTable ()
    {
        $table = data_get($this->providerConnection, 'table');
        $this->setTable($table ?? $this->getTable());
    }

    public function actionTable ()
    {
        $table      = data_get($this->providerConnection, 'table_action' ?? 'table');
        $primaryKey = data_get($this->providerModel, 'primary');

        $this->setTable($table != NULL ? $table : $this->getTable());
        $this->setKeyName($primaryKey ?? $this->primaryKey);

        return $this;
    }

    public function fromTable ($tableName)
    {
        $config = config('callkruger-api.models');

        $this->setTable($tableName);
        $reflection = new \ReflectionClass($this);
        $class      = $reflection->getName();

        dump(data_get($config, $class));

        return $this;
    }

    protected function getProvider ()
    {
        return collect(config('callkruger-api.providers.' . $this->provider));
    }

    public function getTableConnection ($connection = NULL)
    {
        $data  = api_connections($this->getProvider());
        $table = data_get($data, 'table');

        return $table ?? $this->getTable();
    }

    public function resource ($data = NULL, $flip = FALSE)
    {
        $provider = $this->getProvider();

        $data    = $data ?? $this;
        $attrs   = data_get($provider, 'attributes');
        $attrs   = collect(Arr::dot($attrs));
        $collect = $flip ? $attrs->flip() : $attrs;

        $resource = $collect->map(function ($field) use ($data) {
            $col = data_get($data, $field) ?? NULL;

            return is_string($col) ? trim($col) : $col;
        })->all();

        return undot($resource);
    }

    public function relationships ($data = [])
    {
        return $this;
    }
}
