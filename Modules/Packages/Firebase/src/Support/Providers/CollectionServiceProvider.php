<?php

namespace Callkruger\Api\Support\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionServiceProvider extends ServiceProvider {

    /**
     *
     * /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot ()
    {
        $this->registerCollections();
    }

    protected function registerCollections ()
    {
        Collection::macro('serialize', function ($provider, $origin = 'local') {

            $data = $this;

            $config    = is_array($provider) ? $provider : api_provider($provider);
            $relations = data_get($config, 'relations');

            $attributes = data_get($config, 'attributes');
            $attributes = collect(Arr::dot($attributes));

            $collection = $origin == 'local' ? $attributes : $attributes->flip();

            $response = $collection->map(function ($item, $key) use ($origin, $data, $relations) {
                $value    = data_get($data, $item) ?? NULL;
                $relation = data_get($relations, $key) ?? data_get($relations, $item);
                if ( $relation ) {
                    if ( $value ) {
                        foreach ( $value as $subKey => $child ) {
                            if ( $child != NULL ) {
                                data_set($value, $subKey, collect($child)->serialize($relation, $origin));
                            }
                        }
                    }
                }

                return is_string($value) ? trim($value) : $value;
            })->all();

            return undot($response);
        });

        Collection::macro('serialize3', function ($provider = NULL, $flip = FALSE) {

            $data     = $this;
            $provider = api_provider($provider);

            $attributes = data_get($provider, 'attributes');
            $casts      = data_get($provider, 'casts');

            $collect = collect(Arr::dot($attributes));
            $collect = $flip ? $collect->flip() : $collect;

            $response = $collect->map(function ($field, $key) use ($data, $casts, $flip) {
                $name  = $flip ? $key : $field;
                $cast  = data_get($casts, $name);
                $value = data_get($data, $field) ?? NULL;

                switch ( $cast ) {

                    case 'array':
                        $value = is_array($value) ? implode(', ', $value) : explode(', ', $value);
                    break;

                    case 'collection':
                        foreach ( $value as $sub => $val ) {
                            data_set($value, $sub, collect($val)->serialize($name, $flip));
                        }
                    break;
                }

                return is_string($value) ? trim($value) : $value;
            })->all();

            return undot($response);
        });
    }

}
