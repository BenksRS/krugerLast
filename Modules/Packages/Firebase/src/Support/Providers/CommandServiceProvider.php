<?php

namespace Callkruger\Api\Support\Providers;

use Callkruger\Api\Commands\DatabaseSyncCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider {

    /**
     *
     * /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot ()
    {
        $this->app->booted(function () {
            $this->registerSchedule();
            /*            $schedule = $this->app->make(Schedule::class);
            $schedule->command('callkruger:sync --watch')->everyMinute();*/

        });
    }

    protected function registerCommands ()
    {
        if ( $this->app->runningInConsole() ) {
            $this->commands([
                DatabaseSyncCommand::class,
            ]);
        }
    }

    protected function registerSchedule ()
    {

    }

}
