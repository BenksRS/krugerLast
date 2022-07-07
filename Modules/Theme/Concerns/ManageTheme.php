<?php

namespace Modules\Theme\Concerns;

trait ManageTheme {

	/**
	 * @var mixed
	 */
	protected static mixed $classes = [];

	/**
	 * @param $key
	 *
	 * @return array|mixed|string
	 */
	public static function bindClass ($key)
	{
		if ( !static::$classes ) {
			static::$classes = config('theme.css');
		}

		$data = data_get(static::$classes, $key);

		return is_string($data) ? $data : data_get($data, 'class');
	}

}