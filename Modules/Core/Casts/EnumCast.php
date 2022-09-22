<?php

namespace Modules\Core\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class EnumCast implements CastsAttributes {

    /**
     * @param        $model
     * @param string $key
     * @param        $value
     * @param array  $attributes
     *
     * @return mixed
     */
    public function get ($model, string $key, $value, array $attributes)
    {
        return $value == 'Y' ? 1 : 0;
    }

    /**
     * @param        $model
     * @param string $key
     * @param        $value
     * @param array  $attributes
     *
     * @return mixed
     */
    public function set ($model, string $key, $value, array $attributes)
    {
        return $value == 1 ? 'Y': 'N';
    }

}