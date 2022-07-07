<?php

namespace Modules\Core\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Utils\{Database\Mixins\SchemaMixin, PublishModuleResources};

class CoreServiceProvider extends ServiceProvider {

    use PublishModuleResources;

    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Core';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'core';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot ()
    {
        $this->registerMixins();
        $this->registerMiddlewares();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerRelations();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register ()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    public function registerConfig ()
    {
        /*		$this->publishes([
                    module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
                ], 'config');
                $this->mergeConfigFrom(module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower);
                $this->mergeConfigFrom(module_path($this->moduleName, 'Config/menu.php'), $this->moduleNameLower);*/

        $this->publishConfig($this->moduleName, 'config');
        $this->publishConfig($this->moduleName, 'database', TRUE);
        $this->publishConfig($this->moduleName, 'assets', TRUE);
        $this->publishConfig($this->moduleName, 'menu', TRUE);
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
     * Register translations.
     *
     * @return void
     */
    public function registerMiddlewares ()
    {
        try {
            $kernel = $this->app->make(Kernel::class);

            $kernel->appendMiddlewareToGroup('web', \Shipu\Themevel\Middleware\WebMiddleware::class);
            $kernel->appendToMiddlewarePriority(\Shipu\Themevel\Middleware\WebMiddleware::class);
        } catch ( BindingResolutionException $e ) {
        }
    }

    /**
     * Register relations.
     *
     * @return void
     */
    public function registerRelations ()
    {
        /*		$filesystem = new Filesystem();

                $modules  = Module::allEnabled();
                $morphMap = collect();

                foreach ( $modules as $name => $module ) {

                    $path = module_path($name, 'Entities');

                    if ( $filesystem->isDirectory($path) ) {

                        foreach ( $filesystem->allFiles($path) as $file ) {

                            $alias = Str::snake($file->getFilenameWithoutExtension(), '.');

                            $class = Str::afterLast($file->getPathname(), 'Modules');
                            $class = Str::start($class, '\\Modules');
                            $class = strtr($class, ['/' => '\\', '.php' => '']);

                            $morphMap->push(['alias' => $alias, 'class' => $class]);
                        }
                    }
                }
                $morphMap = $morphMap->groupBy('alias')->map(function ($item) {
                    $class = $item->pluck('class');

                    return $class->count() <= 1 ? $class->first() : $class->first();
                })->all();*/

        $config   = collect(config('core.database.relations'));
        $morphMap = $config->mapWithKeys(fn ($item, $key) => is_array($item) ? $item : [$key => $item])->all();

        Relation::enforceMorphMap($morphMap);
    }

    /**
     * Register mixins.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function registerMixins ()
    {
        Blueprint::mixin(new SchemaMixin);
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
