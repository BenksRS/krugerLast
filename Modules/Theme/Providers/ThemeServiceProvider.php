<?php

namespace Modules\Theme\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;
use Modules\Addons\Support\Concerns\CanPublishConfiguration;
use Modules\Theme\Services\FormBuilder;

class ThemeServiceProvider extends ServiceProvider {

	use CanPublishConfiguration;

	/**
	 * @var string $moduleName
	 */
	protected $moduleName = 'Theme';

	/**
	 * @var string $moduleNameLower
	 */
	protected $moduleNameLower = 'theme';

	/**
	 * Bootstrap the application services.
	 */
	public function boot ()
	{
		$this->registerConfig();
		$this->registerComponents();
	}

	/**
	 * Register the application services.
	 */
	public function register ()
	{
		$this->app->singleton(FormBuilder::class, fn () => new FormBuilder);
	}

	/**
	 * Register config.
	 *
	 * @return void
	 */
	protected function registerConfig ()
	{
		$this->publishConfig($this->moduleNameLower, ['config', 'attributes', 'form']);
	}

	protected function registerComponents ()
	{
		$this->getComponents();
	}

	private function getComponents ()
	{
		$path = module_path($this->moduleName, 'View/Components');

		if ( is_dir($path) ) {
			$filesystem = new Filesystem();
			$files      = $filesystem->allFiles($path);

			$this->callAfterResolving(BladeCompiler::class, function () use ($files) {

				$moduleNamespace = config('modules.namespace');

				foreach ( $files as $file ) {

					$alias  = Str::kebab($file->getFilenameWithoutExtension());
					$prefix = Str::kebab($file->getRelativePath());
					$prefix = ($alias !== $prefix) ? $prefix : '';

					$component = Str::after($file->getPathname(), $moduleNamespace);
					$component = Str::start($component, $moduleNamespace);
					$component = strtr($component, ['/' => '\\', '.php' => '']);

					Blade::component($alias, $component, $prefix);
				}
			});
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

}
