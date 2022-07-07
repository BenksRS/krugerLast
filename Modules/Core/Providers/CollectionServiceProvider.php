<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;

class CollectionServiceProvider extends ServiceProvider {

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot ()
    {
        Collection::macro('toObject', function () {
            return json_decode(json_encode((object) $this), FALSE);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register ()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides ()
    {
        return [];
    }

}
