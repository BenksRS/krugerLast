<?php

namespace Callkruger\Api\Database\Casts;

use Illuminate\Contracts\Database\Eloquent\Castable;

class Serialize implements Castable {

    /**
     * Get the name of the caster class to use when casting from / to this cast target.
     *
     * @param  array  $arguments
     * @return string
     */
    public static function castUsing(array $arguments)
    {
        dump($arguments);
        return;
    }

}
