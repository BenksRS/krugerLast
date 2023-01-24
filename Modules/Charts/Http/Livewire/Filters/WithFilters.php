<?php

namespace Modules\Charts\Http\Livewire\Filters;

trait WithFilters {

	public $fields;

	public $filters = [];

	protected function configureFilters ()
	{
		$types  = collect(config('charts.types'));
		$fields = collect(config('charts.fields'));

		$merge = $fields->where('default', TRUE)->merge($this->addFields());

		$this->fields = $merge->map(function( $field, $key ) use ( $types ) {

			$name   = data_get($field, 'name', $key);
			$type   = data_get($field, 'type');
			$input  = data_get($field, 'input');
			$inputs = data_get($types, $type . '.input');

			$field['name']  = $name;
			$field['input'] = $input ?? $inputs;

			return $field;
		})->each(function( $field, $key ) {
			$checked = data_get($field, 'checked');
			$input   = data_get($field, 'input');
			$type    = data_get($field, 'type');

			$value = collect($input)->map(fn() => NULL)->all();
			$value = in_array($type, ['checkbox', 'radio', 'select']) ? $checked : $value;

			$this->filters[$key] = $value;
		})->all();

	}

	protected function addFields (): void {}

	public function submit ()
	{
		$this->emit('chart::filter', $this->filters);
	}

	public function mountWithFilters ()
	{
		$this->configureFilters();
	}

}