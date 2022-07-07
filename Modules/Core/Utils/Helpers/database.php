<?php

use Illuminate\Database\Eloquent\Relations\Relation;

if ( !function_exists('get_connection') ) {

	/**
	 * @param mixed $name
	 *
	 * @return mixed
	 */
	function get_connection ($name = NULL)
	{
		$config = config('core.database');

		if ( $config['debug'] ) {
			return $config['connections']['debug'] ?? $name;
		}

		return $name;
	}
}

if ( !function_exists('relatable_model') ) {

	/**
	 * @param $morph
	 * @param $data
	 *
	 * @return void
	 */
	function relatable_model ($morph, $data)
	{
		if ( $morph && $data ) {
			foreach ( $data as $alias => $items ) {

				$class = class_exists($alias) ? $alias : Relation::getMorphedModel($alias);

				collect($items)
					->groupBy('relatable_id')
					->each(fn ($values, $key) => app($class)->find($key)->$morph()->createMany($values->toArray()));
			}
		}
	}
}
