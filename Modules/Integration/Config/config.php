<?php

use Modules\Integration\Repositories\AssignmentRepository;
use Modules\Integration\Repositories\UserRepository;
use Modules\Integration\Repositories\WorkerRepository;

return [
    'name' => 'Integration',

    'connection' => [

        'users' => [
            'model'    => UserRepository::class,
            'database' => 'users',
            'events '  => [
                'publish' => ['create', 'update', 'delete'],
            ],
        ],

        'workers' => [
            'model'    => WorkerRepository::class,
            'database' => 'workers',
            'events '  => [
                'publish' => ['create', 'update', 'delete'],
            ],
        ],

        'assignments' => [
            'model'    => AssignmentRepository::class,
            'database' => 'jobs',
            'events '  => [
                'publish'   => ['create', 'update', 'delete'],
                'subscribe' => ['update'],
            ],
        ],

        'pictures' => [
            'model'    => '',
            'database' => 'pictures',
            'events '  => [
                'publish'   => ['delete'],
                'subscribe' => ['create'],
            ],
        ],

        'reports' => [
            'model'    => '',
            'database' => 'reports',
            'events'   => [
                'publish'   => ['delete'],
                'subscribe' => ['create', 'update', 'delete'],
            ],
        ],
    ],
];
