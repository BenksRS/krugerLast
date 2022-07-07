<?php

return [

	'input' => [
		[
			'type'   => [
				'text', 'email', 'hidden', 'range', 'tel', 'number', 'date', 'datetimeLocal', 'time', 'week', 'textarea'
			],
			'params' => ['name', 'value']
		],
		[
			'type'   => ['password', 'file'],
			'params' => ['name']
		]
	],

	'checkbox' => [
		[
			'type'   => ['checkbox', 'radio'],
			'params' => ['name', 'value', 'default']
		]
	],

	'select' => [
		[
			'type'   => ['select'],
			'params' => ['name', 'options', 'default']
		],
		[
			'type'   => ['selectRange'],
			'params' => ['name', 'begin', 'end', 'default']
		],
		[
			'type'   => ['selectMonth'],
			'params' => ['name', 'default']
		]
	],
];
