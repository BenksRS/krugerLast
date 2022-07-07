<?php

namespace Modules\Theme\View\Components\Form;

use Modules\Theme\View\BaseComponent;

class Input extends BaseComponent {

	public function __construct (
		public mixed $type = 'text',
		public mixed $name = NULL,
		public mixed $label = NULL,
		public mixed $value = NULL,
		public mixed $cols = NULL
	)
	{
	}

}