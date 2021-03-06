<?php

namespace Callkruger\Api\Support\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as Provider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends Provider {

    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'Callkruger\Api\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot ()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map ()
    {
        $this->mapRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapRoutes ()
    {
        $config  = config('callkruger-api');
        $prefix  = $config['api']['prefix'] ?? 'api';
        $version = $config['api']['version'];

        Route::prefix("$prefix/$version")
             ->middleware('api')
             ->namespace($this->namespace)
             ->name('api.')
             ->group(__DIR__ . '/../../../routes/routes.php');
    }

}
