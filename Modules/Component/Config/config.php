<?php

use Modules\Component\View\Components;

return [
	'name'   => 'Component',
	'prefix' => 'ui',

	'components' => [
		'class' => [
			'form'     => Components\Form\Form::class,
			'input'    => Components\Form\Input\Input::class,
			'select'   => Components\Form\Input\Select::class,
			'checkbox' => Components\Form\Input\Checkbox::class,
			'textarea' => Components\Form\Input\Textarea::class,

			'form-group'     => Components\Form\Group\FormGroup::class,
			'input-group'    => Components\Form\Group\InputGroup::class,
			'checkbox-group' => Components\Form\Group\CheckboxGroup::class,

		]
	]

];
