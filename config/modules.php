<?php

use Nwidart\Modules\Activators\FileActivator;
use Nwidart\Modules\Commands;

return [

	/*
	|--------------------------------------------------------------------------
	| Module Namespace
	|--------------------------------------------------------------------------
	|
	| Default module namespace.
	|
	*/

	'namespace' => 'Modules',

	/*
	|--------------------------------------------------------------------------
	| Module Stubs
	|--------------------------------------------------------------------------
	|
	| Default module stubs.
	|
	*/

	'stubs'    => [
		'enabled'      => FALSE,
		'path'         => base_path('vendor/nwidart/laravel-modules/src/Commands/stubs'),
		'files'        => [
			'routes/web'      => 'Routes/web.php',
			'routes/api'      => 'Routes/api.php',
			'views/index'     => 'Resources/views/index.blade.php',
			'views/master'    => 'Resources/views/layouts/master.blade.php',
			'scaffold/config' => 'Config/config.php',
			'composer'        => 'composer.json',
			'assets/js/app'   => 'Resources/assets/js/app.js',
			'assets/sass/app' => 'Resources/assets/sass/app.scss',
			'webpack'         => 'webpack.mix.js',
			'package'         => 'package.json',
		],
		'replacements' => [
			'routes/web'      => ['LOWER_NAME', 'STUDLY_NAME'],
			'routes/api'      => ['LOWER_NAME'],
			'webpack'         => ['LOWER_NAME'],
			'json'            => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
			'views/index'     => ['LOWER_NAME'],
			'views/master'    => ['LOWER_NAME', 'STUDLY_NAME'],
			'scaffold/config' => ['STUDLY_NAME'],
			'composer'        => [
				'LOWER_NAME',
				'STUDLY_NAME',
				'VENDOR',
				'AUTHOR_NAME',
				'AUTHOR_EMAIL',
				'MODULE_NAMESPACE',
				'PROVIDER_NAMESPACE',
			],
		],
		'gitkeep'      => FALSE,
	],
	'paths'    => [
		/*
		|--------------------------------------------------------------------------
		| Modules path
		|--------------------------------------------------------------------------
		|
		| This path used for save the generated module. This path also will be added
		| automatically to list of scanned folders.
		|
		*/

		'modules' => base_path('Modules'),
		/*
		|--------------------------------------------------------------------------
		| Modules assets path
		|--------------------------------------------------------------------------
		|
		| Here you may update the modules assets path.
		|
		*/

		'assets' => public_path('modules'),
		/*
		|--------------------------------------------------------------------------
		| The migrations path
		|--------------------------------------------------------------------------
		|
		| Where you run 'module:publish-migration' command, where do you publish the
		| the migration files?
		|
		*/

		'migration' => base_path('database/migrations'),
		/*
		|--------------------------------------------------------------------------
		| Generator path
		|--------------------------------------------------------------------------
		| Customise the paths where the folders will be generated.
		| Set the generate key to false to not generate that folder
		*/
		'generator' => [
			'config'          => ['path' => 'Config', 'generate' => TRUE],
			'command'         => ['path' => 'Console', 'generate' => FALSE],
			'migration'       => ['path' => 'Database/Migrations', 'generate' => TRUE],
			'seeder'          => ['path' => 'Database/Seeders', 'generate' => TRUE],
			'factory'         => ['path' => 'Database/factories', 'generate' => TRUE],
			'model'           => ['path' => 'Entities', 'generate' => TRUE],
			'routes'          => ['path' => 'Routes', 'generate' => TRUE],
			'controller'      => ['path' => 'Http/Controllers', 'generate' => TRUE],
			'filter'          => ['path' => 'Http/Middleware', 'generate' => TRUE],
			'request'         => ['path' => 'Http/Requests', 'generate' => TRUE],
			'provider'        => ['path' => 'Providers', 'generate' => TRUE],
			'assets'          => ['path' => 'Resources/assets', 'generate' => TRUE],
			'lang'            => ['path' => 'Resources/lang', 'generate' => TRUE],
			'views'           => ['path' => 'Resources/views', 'generate' => TRUE],
			'test'            => ['path' => 'Tests/Unit', 'generate' => FALSE],
			'test-feature'    => ['path' => 'Tests/Feature', 'generate' => FALSE],
			'repository'      => ['path' => 'Repositories', 'generate' => FALSE],
			'event'           => ['path' => 'Events', 'generate' => FALSE],
			'listener'        => ['path' => 'Listeners', 'generate' => FALSE],
			'policies'        => ['path' => 'Policies', 'generate' => FALSE],
			'rules'           => ['path' => 'Rules', 'generate' => FALSE],
			'jobs'            => ['path' => 'Jobs', 'generate' => FALSE],
			'emails'          => ['path' => 'Emails', 'generate' => FALSE],
			'notifications'   => ['path' => 'Notifications', 'generate' => FALSE],
			'resource'        => ['path' => 'Transformers', 'generate' => FALSE],
			'component-view'  => ['path' => 'Resources/views/components', 'generate' => FALSE],
			'component-class' => ['path' => 'View/Components', 'generate' => FALSE],
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Package commands
	|--------------------------------------------------------------------------
	|
	| Here you can define which commands will be visible and used in your
	| application. If for example you don't use some of the commands provided
	| you can simply comment them out.
	|
	*/
	'commands' => [
		Commands\CommandMakeCommand::class,
		Commands\ComponentClassMakeCommand::class,
		Commands\ComponentViewMakeCommand::class,
		Commands\ControllerMakeCommand::class,
		Commands\DisableCommand::class,
		Commands\DumpCommand::class,
		Commands\EnableCommand::class,
		Commands\EventMakeCommand::class,
		Commands\JobMakeCommand::class,
		Commands\ListenerMakeCommand::class,
		Commands\MailMakeCommand::class,
		Commands\MiddlewareMakeCommand::class,
		Commands\NotificationMakeCommand::class,
		Commands\ProviderMakeCommand::class,
		Commands\RouteProviderMakeCommand::class,
		Commands\InstallCommand::class,
		Commands\ListCommand::class,
		Commands\ModuleDeleteCommand::class,
		Commands\ModuleMakeCommand::class,
		Commands\FactoryMakeCommand::class,
		Commands\PolicyMakeCommand::class,
		Commands\RequestMakeCommand::class,
		Commands\RuleMakeCommand::class,
		Commands\MigrateCommand::class,
		Commands\MigrateRefreshCommand::class,
		Commands\MigrateResetCommand::class,
		Commands\MigrateRollbackCommand::class,
		Commands\MigrateStatusCommand::class,
		Commands\MigrationMakeCommand::class,
		Commands\ModelMakeCommand::class,
		Commands\PublishCommand::class,
		Commands\PublishConfigurationCommand::class,
		Commands\PublishMigrationCommand::class,
		Commands\PublishTranslationCommand::class,
		Commands\SeedCommand::class,
		Commands\SeedMakeCommand::class,
		Commands\SetupCommand::class,
		Commands\UnUseCommand::class,
		Commands\UpdateCommand::class,
		Commands\UseCommand::class,
		Commands\ResourceMakeCommand::class,
		Commands\TestMakeCommand::class,
		Commands\LaravelModulesV6Migrator::class,
		Commands\ComponentClassMakeCommand::class,
		Commands\ComponentViewMakeCommand::class,
	],

	/*
	|--------------------------------------------------------------------------
	| Scan Path
	|--------------------------------------------------------------------------
	|
	| Here you define which folder will be scanned. By default will scan vendor
	| directory. This is useful if you host the package in packagist website.
	|
	*/

	'scan' => [
		'enabled' => FALSE,
		'paths'   => [
			base_path('vendor/*/*'),
		],
	],
	/*
	|--------------------------------------------------------------------------
	| Composer File Template
	|--------------------------------------------------------------------------
	|
	| Here is the config for composer.json file, generated by this package
	|
	*/

	'composer'   => [
		'vendor'          => 'callkruger',
		'author'          => [
			'name'  => 'CallKruger',
			'email' => 'felipe@callkruger.com',
		],
		'composer-output' => FALSE,
	],

	/*
	|--------------------------------------------------------------------------
	| Caching
	|--------------------------------------------------------------------------
	|
	| Here is the config for setting up caching feature.
	|
	*/
	'cache'      => [
		'enabled'  => TRUE,
		'key'      => 'laravel-modules',
		'lifetime' => 60,
	],
	/*
	|--------------------------------------------------------------------------
	| Choose what laravel-modules will register as custom namespaces.
	| Setting one to false will require you to register that part
	| in your own Service Provider class.
	|--------------------------------------------------------------------------
	*/
	'register'   => [
		'translations' => TRUE,
		/**
		 * load files on boot or register method
		 *
		 * Note: boot not compatible with asgardcms
		 *
		 * @example boot|register
		 */
		'files'        => 'register',
	],

	/*
	|--------------------------------------------------------------------------
	| Activators
	|--------------------------------------------------------------------------
	|
	| You can define new types of activators here, file, database etc. The only
	| required parameter is 'class'.
	| The file activator will store the activation status in storage/installed_modules
	*/
	'activators' => [
		'file' => [
			'class'          => FileActivator::class,
			'statuses-file'  => base_path('modules_statuses.json'),
			'cache-key'      => 'activator.installed',
			'cache-lifetime' => 604800,
		],
	],

	'activator' => 'file',
];
