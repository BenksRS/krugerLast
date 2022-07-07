<?php

namespace Modules\Scheduling\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use Modules\Addons\Support\Concerns\CanPublishConfiguration;
use Modules\Scheduling\Support\Timeline;

class SchedulingServiceProvider extends ServiceProvider {

    use CanPublishConfiguration;

    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Scheduling';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'scheduling';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot ()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register ()
    {
        $this->registerSchedules();

        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * @return void
     */
    protected function registerSchedules ()
    {
        $this->app->singleton('scheduling.timeline', function ($app) {
            return new Timeline();
        });
        $this->app->alias('scheduling.timeline', Timeline::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig ()
    {
        $this->publishConfig($this->moduleNameLower, ['config', 'timeline']);
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews ()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations ()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if ( is_dir($langPath) ) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
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

    private function getPublishableViewPaths (): array
    {
        $paths = [];
        foreach ( \Config::get('view.paths') as $path ) {
            if ( is_dir($path . '/modules/' . $this->moduleNameLower) ) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }

        return $paths;
    }

}
