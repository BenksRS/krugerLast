<?php

namespace Modules\Theme\Services;

use Collective\Html\FormFacade as Form;

class FormBuilder {

	public function __construct ()
	{

	}

	/**
	 * @param string $type
	 * @param mixed  $arguments
	 */
	public function control (string $type, mixed ...$arguments)
	{
		dump($type, $arguments);
/*		dump(Form::text(...$arguments));*/
	}

	/*	public function __call (string $name, array $arguments)
		{
			dump($name, ...$arguments);
		}*/

}