<?php

namespace Modules\Component\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;
use Modules\Core\Utils\PublishModuleResources;
use Symfony\Component\Finder\SplFileInfo;

class ComponentServiceProvider extends ServiceProvider {

	use PublishModuleResources;

	/**
	 * @var string $moduleName
	 */
	protected string $moduleName = 'Component';

	/**
	 * @var string $moduleNameLower
	 */
	protected string $moduleNameLower = 'component';

	/**
	 * Bootstrap the application services.
	 */
	public function boot ()
	{
		$this->registerViews();
		$this->registerComponents();
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

	/**
	 * Register config.
	 *
	 * @return void
	 */
	protected function registerConfig ()
	{
		$this->publishConfig($this->moduleName, 'config');
	}

	/**
	 * Register views.
	 *
	 * @return void
	 */
	protected function registerViews ()
	{
		$viewPath = resource_path('views/modules/' . $this->moduleNameLower);

		$sourcePath = module_path($this->moduleName, 'Resources/views');

		$this->publishes([
			$sourcePath => $viewPath
		], ['views', $this->moduleNameLower . '-module-views']);

		$this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
	}

	/**
	 * Register views.
	 *
	 * @return void
	 */
	protected function registerComponents ()
	{

		$this->callAfterResolving(BladeCompiler::class, function () {
			$filesystem = new Filesystem();
			/*			$this->configureClassComponent($filesystem);*/
						/*$this->configureViewComponent($filesystem);*/
/*			$this->configureViewsComponents($filesystem);*/
		});
	}

	protected function configureClassComponent (Filesystem $filesystem)
	{
		$prefix        = $this->getViewPrefix();
		$namespace     = config('modules.namespace');
		$componentPath = module_path($this->moduleName, 'View/Components');

		if ( $filesystem->isDirectory($componentPath) ) {

			$files = $filesystem->allFiles($componentPath);

			foreach ( $files as $file ) {

				$alias = Str::kebab($file->getFilenameWithoutExtension());

				if ( !Str::contains($alias, 'component') ) {

					$component = Str::afterLast($file->getPathname(), $namespace);
					$component = Str::start($component, $namespace);
					$component = strtr($component, ['/' => '\\', '.php' => '']);

					Blade::component($component, $alias, $prefix);
				}
			}
		}
	}

	protected function configureViewComponent (Filesystem $filesystem)
	{
		$prefix       = $this->getViewPrefix();
		$resourcePath = module_path($this->moduleName, 'Resources/views/components');

		if ( $filesystem->isDirectory($resourcePath) ) {

			$files = $filesystem->allFiles($resourcePath);

			$components = [];

			foreach ( $files as $file ) {

				$pathName = $file->getRelativePathname();

				$component = strtr($pathName, ['/' => '.', '.blade.php' => '']);
				$alias     = strtr($component, ['.' => '-', '.index' => '']);

				dump($component, $alias);

				$components = Arr::add($components, $alias, "component::components.stack.$component");
			}

			dd($files);
		}
		$this->loadViewComponentsAs($prefix, $components);
	}

	protected function configureViewsComponents (Filesystem $filesystem)
	{
		$prefix = $this->getViewPrefix();

		$classes = $this->getViewCollection($filesystem, 'classes', 'View/Components');
		$views   = $this->getViewCollection($filesystem, 'views', 'Resources/views/components');

		dd($classes, $views);

		return;

		if ( $filesystem->isDirectory($resourcePath) ) {

			$files = $filesystem->allFiles($resourcePath);

			foreach ( $files as $file ) {

				$pathName  = $file->getRelativePathname();
				$component = strtr($pathName, ['/' => '.', '.blade.php' => '']);

				dump($component);
			}

			dd($files);
		}
		/*		if ( $filesystem->isDirectory($resourcePath) ) {

					$files = $filesystem->allFiles($resourcePath);

					$components = [];

					foreach ( $files as $file ) {

						$pathName = $file->getRelativePathname();

						$component = strtr($pathName, ['/' => '.', '.blade.php' => '']);
						$alias     = strtr($component, ['.' => '-', '.index' => '']);

						$components = Arr::add($components, $alias, "component::components.stack.$component");
					}
				}
				$this->loadViewComponentsAs($prefix, $components);*/
	}

	public function provides ()
	{
		return [];
	}

	private function getViewCollection (Filesystem $filesystem, $type, $path)
	{
		$files = $filesystem->allFiles(module_path($this->moduleName, $path));

		return collect($files)
			->mapWithKeys(fn ($file) => [$this->getViewAlias($file) => $file])
			->except('component');
	}

	private function getViewAlias (SplFileInfo $file)
	{
		$alias = strtr($file->getRelativePathname(), ['.blade' => '', '.php' => '']);

		return Str::of($alias)->explode('/')->map([Str::class, 'kebab'])->implode('-');
	}

	private function getViewPrefix ()
	{
		return config($this->moduleNameLower . '.prefix');
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
