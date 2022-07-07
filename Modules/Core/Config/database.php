<?php

use Modules\Addons\Entities\Assignment\Assignment;
use Modules\Addons\Entities\Assignment\AssignmentJobType;
use Modules\Addons\Entities\Assignment\AssignmentStatus;
use Modules\Addons\Entities\Authorization;
use Modules\Addons\Entities\Collection\CollectionAuthorization;
use Modules\Addons\Entities\Collection\CollectionNote;
use Modules\Addons\Entities\Collection\CollectionPhone;
use Modules\Addons\Entities\Referral\Referral;

return [
	'debug'       => TRUE,
	'connections' => [
		'file'  => 'pgsql',
		'event' => 'redis',
		'debug' => 'debug',
	],

	'map_modules' => [
		'core', 'addons'
	],

	'relations' => [
		'collection_phone'         => CollectionPhone::class,
		'collection_note'          => CollectionNote::class,
		'collection_authorization' => CollectionAuthorization::class,
		'authorization'            => Authorization::class,
		'referral'                 => Referral::class,
		'assignment'               => [
			'assignment'          => Assignment::class,
			'assignment_tag'      => AssignmentStatus::class,
			'assignment_event'    => AssignmentStatus::class,
			'assignment_status'   => AssignmentStatus::class,
			'assignment_job_type' => AssignmentJobType::class,
		],
	],

	'seeders' => [
		\Modules\Addons\Database\Seeders\AuthorizationTableSeeder::class
	]

];
