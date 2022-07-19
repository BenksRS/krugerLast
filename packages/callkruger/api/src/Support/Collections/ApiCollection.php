<?php

namespace Callkruger\Api\Support\Collections;

use Callkruger\Api\Handlers\Events\DataSync;
use Exception;

class ApiCollection {

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $config;

    /**
     * @var string|null
     */
    protected $provider;

    /**
     * @var mixed|null
     */
    protected $data;

    public function __construct (string $provider = NULL)
    {
        $this->config   = collect(config('callkruger-api.providers'));
        $this->provider = $provider;
    }

    public function __call ($method, array $arguments)
    {
        $arguments = count($arguments) === 1 ? $arguments[0] : $arguments;

        if ( preg_match('~^(sync)([A-Z])(.*)$~', $method, $matches) ) {
            $this->provider = strtolower($matches[2]) . $matches[3];
        } else {
            $this->provider = $method;
        }
        $this->sync($arguments);
    }

    public function sync ($uid = NULL, $delete = FALSE, $event = 'sync')
    {
        $resource = [
            'provider'   => $this->provider,
            'uid'        => $uid,
            'delete'     => $delete,
            'event'      => $event,
            'connection' => 'network'
        ];

        try {
            /*            $this->resolveData();*/
            event(new DataSync($resource));
        } catch ( Exception $e ) {
            echo $e->getMessage();
        }
    }

    public function syncData ($uid = NULL, $delete = FALSE, $event = 'sync')
    {
        $resource = [
            'provider'   => $this->provider,
            'uid'        => $uid,
            'delete'     => $delete,
            'event'      => $event,
            'connection' => 'network'
        ];

        try {
            /*            $this->resolveData();*/
            event(new DataSync($resource));
        } catch ( Exception $e ) {
            echo $e->getMessage();
        }
    }

    /**
     * @throws Exception
     */
    protected function resolveData ()
    {
        $data       = data_get($this->config, $this->collection);
        $this->data = $data ?? NULL;

        if ( !$this->data )
            throw new Exception(sprintf('Collection %s does not exist.', $this->collection));
    }

}
