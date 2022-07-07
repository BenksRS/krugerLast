<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Nwidart\Modules\Facades\Module;

class RouteServiceProvider extends ServiceProvider {

    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Core\Http\Controllers';

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
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes ()
    {
/*        $modules = Module::toCollection()->filter(function ($module) {
            return is_file($module->getExtraPath('Routes/web.php'));
        });*/

/*        Route::middleware(['web', 'auth:user'])->group(function ($route) use ($modules) {
            foreach ( $modules->all() as $module ) {
                dump($module->getName());
                $namespace = 'Modules\\' . $module->getName() . '\\Http\\Controllers';
                Route::namespace($namespace)->group(module_path($module->getName(), '/Routes/web.php'));
            }
        });*/
       Route::middleware('web')->namespace($this->moduleNamespace)->group(module_path('Core', '/Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes ()
    {
        Route::prefix('api')->middleware('api')->namespace($this->moduleNamespace)->group(module_path('Core', '/Routes/api.php'));
    }

}
