<?php

namespace Callkruger\Api\Support\Repositories;

use ReflectionClass;
use ReflectionException;

class AuthRepository {

    /**
     * @var array
     */
    protected $items;

    protected $guard;

    protected $provider;

    public function __construct ($guard = 'employees')
    {

        $this->guard    = $guard;
        $this->provider = $this->resolveProvider();
    }

    protected function resolveProvider ()
    {
        $provider = api_provider($this->guard);
        $isAuth   = data_get($provider, 'auth');

        return $provider;

        return $provider && $isAuth ? $provider : [];
    }

    public function login ($credentials)
    {
        try {

            $model = new ReflectionClass(data_get($this->provider, 'model'));
            $model = $model->newInstance();

            $data = $model->find(5);
            /*            $data = $model->whereIn('id', [1,2,3,4,5])->get();*/
            /*            $credentials = json_decode(json_encode($credentials));*/
            collect();
            $local   = collect($data)->serialize($this->provider);
            $network = collect($credentials)->serialize('reports', 'network');
            $model->create($network)->relationships($network);
            /*            $this->items->provider($this->provider)->serialize($data);
                        $this->items->provider('reports')->serialize($credentials);*/
        } catch ( ReflectionException $e ) {
        }

        return $this;
    }

    public function __call ($name, array $arguments)
    {
        $arguments = count($arguments) === 1 ? $arguments[0] : $arguments;
        if ( $arguments ) {
            $this->$name = $arguments;
        }

        return $this;
    }

}
