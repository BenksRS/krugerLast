<?php

namespace Callkruger\Api\Support\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider as Provider;

class RelationServiceProvider extends Provider {

    /**
     *
     * /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot ()
    {
        $config = collect(config('callkruger-api.providers'));

        Relation::morphMap($config->map(function ($value) {
            return $value['model'];
        })->all());


    }

}
