<?php

return [
	'name' => 'Charts',

	'types' => [
		'daterange' => [
			'input' => [
				'start' => 'Start Date',
				'end'   => 'End Date',
			],
		],
	],

	'fields' => [
		'dates'    => [
			'type'    => 'daterange',
			'name'    => 'dates',
			'default' => TRUE,
		],
	],

	'views' => [
		'referral' => [
			'referral'          => 'charts::show.referral.referrals',
			'referral_carriers' => 'charts::show.referral.referrals',
			'referral_types'    => 'charts::show.referral.types',
		]
	],

	'template' => [
		'chartjs' => [
			'labels'   => 'DATA_LABEL',
			'datasets' => 'DATA_VALUE',
		]
	],

	'colors' => [
		'primary'   => '#5A8DEE',
		'secondary' => '#5C5C5C',
		'success'   => '#39DA8A',
		'danger'    => '#FF5B5C',
		'warning'   => '#FDAC41',
		'info'      => '#00CFDD',
		'indigo'    => '#564AB1',
	],

];
