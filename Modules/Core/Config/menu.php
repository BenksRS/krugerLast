<?php

return [
	'vertical' => [
		['header' => 'Menu'],
		[
			'key'     => 'assignments',
			'text'    => 'Assignments',
			'submenu' => [
				['text' => 'List all', 'route' => 'assignments'],
				['text' => 'Show', 'route' => ['assignments.show', 'id' => 1]]
			]
		]
	],
];
