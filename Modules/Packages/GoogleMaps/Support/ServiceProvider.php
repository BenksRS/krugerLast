<?php

namespace Modules\Packages\GoogleMaps\Support;

use Illuminate\Foundation\AliasLoader;
use Modules\Packages\GoogleMaps\GoogleMaps;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {

    public function boot ()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'google-maps');

        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('google-maps.php'),
        ], 'config');
    }

    public function register ()
    {

        $this->app->singleton('google-maps', function ($app) {
            return new GoogleMaps(config('google-maps.api_key'));
        });

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('GoogleMaps', \Modules\Packages\GoogleMaps\Facades\GoogleMaps::class);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides ()
    {
        return ['google-maps'];
    }

}