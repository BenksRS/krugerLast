<?php

namespace Modules\Core\Utils;

trait PublishModuleResources {

	/**
	 * Publish the given configuration file name (without extension) and the given module
	 *
	 * @param string $module
	 * @param string $file
	 * @param bool   $merge
	 */
	public function publishConfig ($module, $file, $merge = FALSE)
	{
		if ( app()->environment() === 'testing' ) {
			return;
		}

		$moduleLower = strtolower($module);
		$merge       = $merge ? "$moduleLower.$file" : $moduleLower;

		$sourcePath = module_path($module, "Config/$file.php");
		$configPath = config_path($moduleLower . '.php');

		$this->mergeConfigFrom($sourcePath, $merge);
		$this->publishes([$sourcePath => $configPath], 'config');
	}

	public function publishMigrations ()
	{
		$sourcePath = module_path($this->moduleName, 'Database/Migrations');
		$paths      = glob($sourcePath . '/*', GLOB_ONLYDIR);
		$paths      = array_merge([$sourcePath], $paths);


		$this->loadMigrationsFrom($paths);
	}

}