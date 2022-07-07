<?php

return [
	'name' => 'Element',

	'form2' => [

		'input' => [
			'view' => '',
			'type' => ['text', 'email', 'password', 'number', 'textarea'],
		],

		'checkbox' => [
			'view'    => '',
			'type'    => ['checkbox', 'radio'],
			'options' => ['group' => TRUE]
		],

		'select' => [
			'view'    => '',
			'type'    => ['select'],
			'options' => ['multiple' => TRUE, 'model' => TRUE]
		]
	],

	'components2' => [
		[
			'name'  => 'active',
			'label' => 'Active',
			'type'  => 'option.radio',
			'data'  => ['N' => 'No', 'Y' => 'Yes']
		],
		[
			'name'  => 'username',
			'label' => 'Username',
			'type'  => 'input.text'
		]
	]
];
