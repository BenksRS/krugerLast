<?php

namespace Modules\Theme\View\Components\Form;

use Modules\Theme\View\BaseComponent;

class Checkbox extends BaseComponent {

	public function __construct (
		public mixed $type = 'checkbox',
		public mixed $name = NULL,
		public mixed $label = NULL,
		public mixed $value = NULL,
		public mixed $options = [],
		public mixed $cols = NULL
	)
	{

	}

}