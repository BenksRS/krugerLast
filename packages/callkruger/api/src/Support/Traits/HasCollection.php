<?php

namespace Callkruger\Api\Support\Traits;

use Illuminate\Support\Arr;

trait HasCollection {

    public static function bootHasCollection ()
    {

        static::retrieved(function (self $model) {
            $provider   = $model->getProvider();
            $attributes = data_get($provider, 'attributes');
            $relations  = data_get($provider, 'relations');
            $collection = collect(Arr::dot($attributes));
            if ( $relations ) {
                $model->loadMissing($relations);
            }
            dump($model->toArray());

            /*            if ( $relations ) {
                            $relations     = collect($relations)->mapWithKeys(function ($item) {
                                return [$item => Str::studly($item)];
                            })->all();
                        }
                        $resource = $collection->map(function ($field, $key) use ($model, $relations) {
                            $field = data_get($relations, $field) ?? $field;
                            $value = data_get($model, $field) ?? NULL;


                            return $value;
                                     $col = data_get($model, $field) ?? NULL;

                                      return is_string($col) ? trim($col) : $col;
                        })->toArray();
                        $undot    = undot($resource);
                        dump($resource);*/

            /*          $undot    = undot($resource);
                      dump($attributes);*/

            /*            dump($model->setAttribute('asds', 'asdee'));
                        dump($model->only(['asds', 'id_assignment', 'tarpSize2']));
                        dump($model->getAttributes());*/

            /*            $new = $model->syncOriginal();*/
            /*            // Automatically generate a UUID if using them, and not provided.
                        if (empty($model->{$model->getKeyName()})) {
                            $model->{$model->getKeyName()} = guid();
                        }*/
        });
    }

}
