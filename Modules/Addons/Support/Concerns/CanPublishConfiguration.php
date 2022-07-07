<?php

namespace Modules\Addons\Support\Concerns;

trait CanPublishConfiguration {

	/**
	 * @param string       $module
	 * @param array|string $paths
	 *
	 * @return void
	 */
	protected function publishConfig ($module, $paths)
	{
		$paths     = is_array($paths) ? $paths : [$paths];
		$publishes = [];

		foreach ( $paths as $path ) {
			$key = strtolower($path === 'config' ? $module : "{$module}.{$path}");

			$sourcePath = module_path($module, "Config/{$path}.php");
			$configPath = config_path("modules/{$module}/{$path}.php");

			if ( is_file($sourcePath) ) {
				$this->mergeConfigFrom($sourcePath, $key);

				$publishes = array_merge($publishes, [$sourcePath => $configPath]);
			}
		}

		$this->publishes($publishes, 'config');
	}

}