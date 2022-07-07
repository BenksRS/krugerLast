<?php

namespace CallKruger\BladeComponents\View\Components\Form;

use CallKruger\BladeComponents\View\Components\BaseComponent;

abstract class Component extends BaseComponent {

	/**
	 * @param string      $type
	 * @param string      $name
	 * @param string|null $label
	 * @param mixed|null  $value
	 * @param mixed|null  $cols
	 */
	public function __construct (
		public string $type,
		public string $name,
		public ?string $label = NULL,
		public $value = NULL,
		public $cols = NULL
	)
	{
		parent::__construct('form');
	}

}