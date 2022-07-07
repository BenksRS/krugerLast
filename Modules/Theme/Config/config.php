<?php

return [

	[
		'form'     => [
			'main' => ['class' => 'needs-validation', 'novalidate'],
		],
		'input'    => [
			'input' => [
				'main' => ['class' => 'form-control'],
				'sm'   => ['class' => 'form-control-sm'],
				'lg'   => ['class' => 'form-control-lg'],
			],
			'label' => [
				'main' => ['class' => 'form-label'],
				'grid' => ['class' => 'col-form-label'],
			],

		],
		'checkbox' => [
			'main'  => ['class' => 'form-check-input'],
			'label' => ['class' => 'form-check-label'],
			'group' => [
				'merge'  => ['class' => 'form-check'],
				'switch' => ['class' => 'form-switch'],
				'inline' => ['class' => 'form-check-inline'],
			]
		],
	],

	'css' => [
		'form'     => 'needs-validation',
		'label'    => 'form-label',
		'select'   => 'form-select',
		'input'    => [
			'class' => 'form-control',
			'label' => 'form-label',
			'group' => 'input-group',
			'text'  => 'input-group-text',
		],
		'checkbox' => [
			'class'  => 'form-check-input',
			'label'  => 'form-check-label',
			'group'  => 'form-check',
			'switch' => 'form-check form-switch',
			'inline' => 'form-check form-check-inline',
		],
		'error'    => [
			'input'   => 'is-invalid',
			'section' => 'invalid-feedback',
		],
	],
];
