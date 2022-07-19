<?php

namespace Callkruger\Api;

use Callkruger\Api\Support\Repositories\AuthRepository;
use Callkruger\Api\Support\Traits\Manager\ManagerAuth;
use Callkruger\Api\Support\Traits\Manager\ManagerBuilder;
use Callkruger\Api\Support\Traits\Manager\ManagerProvider;
use Illuminate\Contracts\Container\Container;

class Manager {

    use ManagerBuilder;
    use ManagerProvider;
    use ManagerAuth;

    protected $providers;

    protected $provider;

    protected $arguments;

    protected $connection = 'local';

    public function __construct (Container $app)
    {
        $this->providers = config('callkruger-api.providers');
        /*        $this->provider = $this->getProvider();

                $this->model = app($this->provider['model'] ?? NULL);*/
    }

    public function __call ($name, array $arguments)
    {
        $arguments = count($arguments) === 1 ? $arguments[0] : $arguments;

        if ( !property_exists($this, $name) ) {
            $this->arguments[$name] = $arguments;
        } else {
            $this->$name = $arguments;
        }

        return $this;
    }

    /**
     * @return AuthRepository
     */
    public function auth2 ($guard = NULL)
    {
        return (new AuthRepository($guard));
    }

}
