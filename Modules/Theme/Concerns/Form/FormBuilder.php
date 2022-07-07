<?php

namespace Modules\Theme\Concerns\Form;

use Illuminate\Support\Str;
use InvalidArgumentException;

trait FormBuilder {

	/**
	 * @var mixed
	 */
	protected static mixed $fields = [];

	public function formField ($type, ...$parameters)
	{

		if ( !static::$fields ) {
			static::$fields = config('theme.form');
		}

		$fields     = data_get(static::$fields, Str::kebab(class_basename($this)));
		$collection = collect($fields)
			->filter(fn ($value) => in_array($type, $value['type']))
			->pluck('params')->collapse();

		$collection = $collection->mapWithKeys(function ($item, $key) use ($parameters) {

			$value = $parameters[$item] ?? $this->{$item} ?? NULL;

			return [$key => $value];
		})->all();

		return \Form::$type(...$collection);
	}

	public function formControl ($type, ...$parameters)
	{

		if ( $type ) {
			$type = Str::camel($type);

			$arguments = match ($type) {
				'file', 'password'  => ['name'],
				'radio', 'checkbox' => ['name', 'value', 'default'],
				'select'            => ['name', 'items', 'default'],
				'selectRange'       => ['name', 'min', 'max', 'default'],
				'selectMonth'       => ['name', 'default'],
				default             => ['name', 'value'],
			};

			dump($arguments);

			$arguments = collect($arguments)->mapWithKeys(function ($item, $key) use ($parameters) {

				$value = $parameters[$item] ?? $this->{$item} ?? NULL;

				return [$key => $value];
			})->all();

			dump(\Form::$type(...$arguments));
			return;
		}

		throw new InvalidArgumentException();
	}

	public function __call (string $name, array $arguments)
	{
		// TODO: Implement __call() method.
	}

	public static function __callStatic (string $name, array $arguments)
	{
		// TODO: Implement __callStatic() method.
	}

}