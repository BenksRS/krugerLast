<?php

namespace CallKruger\BladeComponents\View\Components\Form;

class Input extends Component {

	/**
	 * @param string      $type
	 * @param string      $name
	 * @param string|null $label
	 * @param mixed|null  $value
	 * @param mixed|null  $cols
	 */
	public function __construct (
		string $type,
		string $name,
		?string $label = NULL,
		$value = NULL,
		$cols = NULL
	)
	{
		parent::__construct($type, $name, $label, $value, $cols);
	}

}