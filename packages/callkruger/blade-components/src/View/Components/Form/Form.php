<?php

namespace CallKruger\BladeComponents\View\Components\Form;

use CallKruger\BladeComponents\Concerns\Form\DataBinder;
use CallKruger\BladeComponents\View\Components\BaseComponent;

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
		parent::__construct('form');

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