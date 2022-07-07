<?php

namespace Modules\Theme\View\Components\Form;

use Modules\Theme\Concerns\Form\DataBinder;
use Modules\Theme\View\BaseComponent;

class Form extends BaseComponent {

	use DataBinder;

	/**
	 * @var string
	 */
	public string $method = 'POST';

	/**
	 * @var string
	 */
	public string $route;

	/**
	 * @var \Illuminate\Database\Eloquent\Model
	 */
	public mixed $model;

	public function __construct ($method, $route, $model = NULL)
	{
		$this->method = strtoupper($method);
		$this->route  = $route;
		$this->model  = $model;

		$this->modelBinding($this->model);
	}

	public function formAttributes ($attributes = NULL): array
	{
		$base = [
			'method' => $this->method,
			'route'  => [$this->route, $this->model],
		];

		return collect($base)->merge($attributes)->all();
	}

}