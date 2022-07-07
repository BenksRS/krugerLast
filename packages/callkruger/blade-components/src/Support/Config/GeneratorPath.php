<?php

namespace CallKruger\BladeComponents\Support\Config;

class GeneratorPath {

	/**
	 * @var mixed
	 */
	private mixed $path;

	/**
	 * @var mixed|bool
	 */
	private mixed $generate;

	/**
	 * @var array|mixed|string|string[]
	 */
	private mixed $namespace;

	/**
	 * @param $config
	 */
	public function __construct ($config)
	{
		if ( is_array($config) ) {
			$this->path      = $config['path'];
			$this->generate  = $config['generate'];
			$this->namespace = $config['namespace'] ?? $this->convertPathToNamespace($config['path']);

			return;
		}
		$this->path      = $config;
		$this->generate  = (bool) $config;
		$this->namespace = $config;
	}

	/**
	 * @return mixed
	 */
	public function getPath (): mixed
	{
		return $this->path;
	}

	/**
	 * @return bool
	 */
	public function generate (): bool
	{
		return $this->generate;
	}

	/**
	 * @return mixed
	 */
	public function getNamespace (): mixed
	{
		return $this->namespace;
	}

	/**
	 * @param $path
	 *
	 * @return array|string
	 */
	private function convertPathToNamespace ($path): array|string
	{
		return str_replace('/', '\\', $path);
	}

}