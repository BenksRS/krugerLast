<?php

namespace CallKruger\BladeComponents;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {

	/** @var string */
	private const KEY       = 'ui';

	/** @var string */
	private const NAMESPACE = '\CallKruger\BladeComponents\View\Components';

	/** @var string */
	private const CONFIG_FILE = __DIR__ . '/../config/config.php';

	/** @var string */
	private const PATH_VIEWS = __DIR__ . '/../resources/views';

	/**
	 * Boot the application events.
	 *
	 * @return void
	 */
	public function boot ()
	{
		$this->registerViews();
		$this->configureComponents();
		/*		Blade::componentNamespace("MichelVieira\\Collections\\View\\Components", 'collections');*/
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register ()
	{
		$this->registerConfig();
	}

	protected function registerConfig ()
	{
		$this->mergeConfigFrom(self::CONFIG_FILE, self::KEY);
	}

	protected function registerViews ()
	{
		$this->loadViewsFrom(self::PATH_VIEWS, self::KEY);
	}

	protected function configureComponents ()
	{
		$components = config(self::KEY . '.components');

		$this->callAfterResolving(BladeCompiler::class, function () use ($components) {
			Collection::make($components)->map(function ($data, $prefix) {
				if ( is_array($data) ) {
					foreach ( $data as $alias => $component ) {
						$this->registerComponents($component, $alias, $prefix);
					}
				} else {
					$this->registerComponents($data, $prefix);
				}
			});
		});
	}

	protected function registerComponents ($component, $alias, $prefix = NULL)
	{
		$prefix = $prefix != $alias ? $prefix : NULL;
		if ( class_exists($component) ) {
			Blade::component($component, $alias, $prefix);
		} else {
			Blade::component(self::KEY . '::components.' . $component, $alias, $prefix);
		}
	}

	protected function registerComponents2 ()
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

}
