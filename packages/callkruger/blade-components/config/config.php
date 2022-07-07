<?php

use CallKruger\BladeComponents\View\Components;

return [

	/*
	|--------------------------------------------------------------------------
	| Components
	|--------------------------------------------------------------------------
	*/
	'components' => [
		'form' => [
			'form'  => Components\Form\Form::class,
			'input' => Components\Form\Input::class,
		],
		'card' => 'card'
	]
];