<?php

namespace Callkruger\Api\Support\Providers;

use Callkruger\Api\Commands\DatabaseSyncCommand;
use Callkruger\Api\Manager;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider as Provider;

class ServiceProvider extends Provider {

    protected $config = 'callkruger';

    public function boot ()
    {
        $this->publishesConfig();
        $this->registerMigrations();
        $this->registerCommands();
    }

    public function register ()
    {
        $this->registerConfig();
        $this->registerProviders();
        $this->registerFacades();
    }

    protected function publishesConfig ()
    {
        $this->publishes([__DIR__ . '/../../../config/config.php' => config_path($this->config . '-api.php')]);
    }

    protected function registerConfig ()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../../config/config.php', $this->config . '-api');
        /*        $this->mergeConfigFrom(__DIR__ . '/../../../config/config_v2.php', $this->config . '-api');*/
    }

    protected function registerMigrations ()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../../database/migrations');
    }

    protected function registerProviders ()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RelationServiceProvider::class);
        $this->app->register(ObserverServiceProvider::class);
        $this->app->register(CollectionServiceProvider::class);
    }

    protected function registerFacades ()
    {
        $this->app->singleton('manager', function ($app) {
            return new Manager($app);
        });
    }

    protected function registerCommands ()
    {
        if ( $this->app->runningInConsole() ) {
            $this->commands([
                DatabaseSyncCommand::class,
            ]);
        }
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command($this->config . ':sync --watch')->withoutOverlapping()->everyMinute();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides ()
    {
        return ['manager'];
    }

}
