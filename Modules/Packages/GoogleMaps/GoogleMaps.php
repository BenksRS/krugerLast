<?php

namespace Modules\Packages\GoogleMaps;

use BadMethodCallException;

class GoogleMaps {

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct (string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param $method
     *
     * @return mixed
     */
    protected function hasService ($method)
    {
        $serviceName = mb_strtolower($method);
        $webServices = config("google-maps.service");

        if ( !array_key_exists($serviceName, $webServices) ) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', static::class, $method
            ));
        }

        $service = $webServices[$serviceName];
        $class   = $service['class'];

        return new $class($this->apiKey, $service);
    }

    /**
     * @param        $method
     * @param        $parameters
     *
     * @return mixed
     */
    public function __call ($method, $parameters)
    {
        return static::hasService($method);
    }

}