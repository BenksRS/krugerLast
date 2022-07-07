<?php

return [
	'name' => 'Scheduling',

	'timeline' => [

		// Determines the first time slot that will be displayed for each day.
		'min_time'       => '00:00:00',

		// Determines the last time slot that will be displayed for each day.
		'max_time'       => '24:00:00',

		// Determines how far forward the scroll pane is initially scrolled.
		'scroll_time'    => '08:00:00',

		// Determines the text that will be displayed within a time slot.
		'label_format'    => [
			'hour'     => 'H:i',
			'meridiem' => 'hA',
			'datetime' => 'Y-m-d\TH:i:s',
		],

		// The frequency that the time slots should be labelled with text. (60 minutes)
		'label_interval' => 60,

		// The frequency for displaying time slots. (30 minutes)
		'event_duration' => 30,

	]
];
