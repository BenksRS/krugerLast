<?php

namespace Callkruger\Api\Database\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Join implements CastsAttributes {

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
        $collect = collect(explode(', ', $value))->map(function ($item) {
            return is_numeric($item) ? (int) $item : trim($item);
        });

        return $collect->all();
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
        return implode(', ', $value);
    }

}
