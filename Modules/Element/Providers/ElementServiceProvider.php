<?php

namespace Modules\Element\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Utils\PublishModuleResources;

class ElementServiceProvider extends ServiceProvider {

	use PublishModuleResources;

	/**
	 * @var string $moduleName
	 */
	protected string $moduleName = 'Element';

	/**
	 * @var string $moduleNameLower
	 */
	protected $moduleNameLower = 'element';

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
		$this->registerComponents();
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
	protected function registerConfig ()
	{
		$this->publishConfig($this->moduleName, 'config');
		$this->publishConfig($this->moduleName, 'components', TRUE);
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
			$sourcePath => $viewPath
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
	 * Register components.
	 *
	 * @return void
	 */
	protected function registerComponents ()
	{
		/*		$filesystem = new Filesystem();
		$configPath = module_path($this->moduleName, 'Config');

		collect($filesystem->allFiles($configPath))->each(function ($file) {
			$fileName = strtr($file->getFileName(), ['/' => '\\', '.php' => '']);
			$this->publishConfig($this->moduleName, $fileName, TRUE);
		});*/
		/*		$prefix = config("{$this->moduleNameLower}.components.prefix");
				foreach ( $prefix as $tag => $name ) {

					$namespace = "Modules\\Element\\View\\Components";
					$namespace = $name == NULL ? $namespace : $namespace . '\\' . $name;

					Blade::componentNamespace($namespace, $tag);
				}*/
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
