<?php

namespace Modules\Addons\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Addons\Support\Concerns\CanPublishConfiguration;

class AddonsServiceProvider extends ServiceProvider {

	use CanPublishConfiguration;

	/**
	 * @var string
	 */
	protected string $moduleName = 'Addons';

	/**
	 * @var string
	 */
	protected string $moduleNameLower = 'addons';

	/**
	 * Booting the package.
	 */
	public function boot ()
	{
		$this->publishConfig($this->moduleNameLower, ['config']);
		$this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register ()
	{
		//
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
