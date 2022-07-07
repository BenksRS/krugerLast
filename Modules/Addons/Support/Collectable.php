<?php

namespace Modules\Addons\Support;

use Illuminate\Database\Eloquent\{
	Model,
	Relations\MorphMany,
	Relations\MorphToMany
};

use Illuminate\Support\Collection;

class Collectable {

	/**
	 * @var Model
	 */
	protected Model $model;

	/**
	 * @var string
	 */
	protected string $relation;

	/**
	 * @var mixed|array
	 */
	protected mixed $items = [];

	/**
	 * @param Model  $model
	 * @param string $relation
	 */
	public function __construct (Model $model, string $relation)
	{
		$this->model  = $model;
		$this->relation = $relation;
	}

	/**
	 * @param $items
	 *
	 * @return void
	 */
	public function sync ($items)
	{

		if ( !method_exists($this->model, $this->relation) ) {
			throw new \BadMethodCallException(sprintf(
				'Call to undefined related method %s::%s()', get_class($this->model), $this->relation
			));
		}
		$this->setCollectableValues($items);
		$query = $this->query();

		if ( $query instanceof Model ) $this->save($query);

		if ( $query instanceof Collection ) $query->each(fn (Model $model) => $this->save($model));
	}

	/**
	 * @param $items
	 *
	 * @return void
	 */
	protected function setCollectableValues ($items)
	{
		$items = collect($items);

		$this->items = [
			'keys'  => $items->pluck('collect_id')->unique()->filter()->values()->all(),
			'items' => $items
		];
	}

	/**
	 * @param array|string $keys
	 *
	 * @return array
	 */
	protected function getCollectableValue ($keys)
	{
		/** @var Collection $items */
		$items = $this->items['items'];

		$return = is_array($keys)
			? $items->whereIn('collect_id', $keys)
			: $items->where('collect_id', $keys);

		return $return->values()->all();
	}

	/**
	 * @return Collection
	 */
	protected function query ()
	{
		$query = $this->model;

		if ( !$query->getKey() ) {
			$query = $query->find($this->items['keys']);
		}

		return $query;
	}

	/**
	 * @param Model $model
	 *
	 * @return void
	 */
	protected function save (Model $model)
	{
		$relation = $model->{$this->relation}();
		$items    = $this->getCollectableValue($model->getKey());
		switch ( TRUE ) {
			case $relation instanceof MorphMany:
				$relation->createMany($items);
			break;
			case $relation instanceof MorphToMany:
				$relation->attach($items);
			break;
			default:
			break;
		}
	}

}