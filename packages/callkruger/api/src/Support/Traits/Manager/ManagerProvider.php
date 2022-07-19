<?php

namespace Callkruger\Api\Support\Traits\Manager;

use Callkruger\Api\Handlers\Events\DataSync;
use Callkruger\Api\Handlers\Events\ProviderProcessed;

trait ManagerProvider {

    public function provider ($provider = NULL)
    {
        $this->provider = $this->resolveProvider($provider);

        return $this;
    }

    public function getProvider ()
    {
        return $this->resolveProvider();
    }

    protected function resolveProvider ($provider = NULL)
    {
        $collection = data_get($this->providers, $provider);

        if ( !$collection ) {
            api_response(401, 'Invalid provider.');
        }

        return $collection;
    }

    public function syncTest ($key = NULL, $delete = FALSE)
    {
        $data = [
            'providers' => $this->providers,
            'provider'  => $this->provider,
            'origin'    => $this->origin,
            'data'      => $this->data,
            'builder'   => $this->builder,
            'key'       => $key,
            'delete'    => $delete,
        ];

        event(new ProviderProcessed($data));
    }

    public function sync ($provider = NULL, $uid = NULL, $delete = FALSE)
    {
        $resource = [
            'provider'   => $provider,
            'uid'        => $uid,
            'delete'     => $delete,
            'event'      => 'sync',
            'connection' => 'network'
        ];
        event(new DataSync($resource));
    }

    public function syncAll ($providers = [])
    {
        $resource = [
            'event'      => 'sync',
            'connection' => 'network'
        ];
        event(new DataSync($resource));
    }

    public function retrieve ()
    {
        $resource = [
            'event' => 'retrieve'
        ];
        event(new DataSync($resource));
    }

}
