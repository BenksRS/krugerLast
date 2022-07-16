<?php

namespace Callkruger\Api\Database\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Json implements CastsAttributes {

    /**
     * Cast the given value.
     *
     * @param Model  $model
     * @param string $key
     * @param mixed  $value
     * @param array  $attributes
     *
     * @return array
     */
    public function get ($model, $key, $value, $attributes)
    {
        if ( $value ) {
            $name = $model->checkListName ?? null;

            $value = collect(json_decode($value, TRUE));

            $get = $value->transform(function ($item, $key) use ($name) {
                $val = $item == 'N' ? 0 : 1;

                return ['name' => $name[$key], 'value' => $val];
            })->values()->forget(0)->values()->all();

            return $get;
        }

        return NULL;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model  $model
     * @param string $key
     * @param array  $value
     * @param array  $attributes
     *
     * @return string
     */
    public function set ($model, $key, $value, $attributes)
    {
        if ( $value ) {
            $set = collect($value)->prepend(1)->transform(function ($item, $key) {
                $val = $item['value'] ?? $item;
                $val = $val == 0 ? 'N' : 'Y';

                return [$key => $val];
            })->collapse()->all();

            array_unshift($set, NULL);
            unset($set[0]);

            return json_encode($set);
        }

        return NULL;
    }

}
