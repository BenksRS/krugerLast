<?php

use Modules\Integration\Repositories;

return [
    'name' => 'Integration',

    'actions' => [
        'local'  => ['create', 'update', 'delete'],
        'remote' => ['create', 'update', 'delete'],
    ],

    'connection' => [

        'users' => [
            'model'  => Repositories\IntegrationUserRepository::class,
            'table'  => 'users',
            'queues' => [
                'set' => TRUE,
                'get' => FALSE,
            ],
            'events' => [],
            'rules'  => [],
        ],

        'workers' => [
            'model'  => Repositories\IntegrationWorkerRepository::class,
            'table'  => 'workers',
            'queues' => [
                'set' => TRUE,
                'get' => FALSE,
            ],
            'events' => [],
            'rules'  => [],
        ],

        'assignments' => [
            'model'  => Repositories\IntegrationAssignmentRepository::class,
            'table'  => 'jobs',
            'queues' => [
                'set' => FALSE,
                'get' => TRUE,
            ],
            'events' => ['local.update'],
            'rules'  => [
                'local.update' => [
                    'status.new' => ['in_progress', 'uploading', 'uploading_pics'],
                ],
            ],
        ],

        'pictures' => [
            'model'  => Repositories\IntegrationPictureRepository::class,
            'table'  => 'pictures',
            'queues' => [
                'set' => FALSE,
                'get' => TRUE,
            ],
            'events' => ['local.create', 'remote.delete'],
            'rules'  => [],
        ],

        'signatures' => [
            'model'  => Repositories\IntegrationSignatureRepository::class,
            'table'  => 'signatures',
            'queues' => [
                'set' => FALSE,
                'get' => TRUE,
            ],
            'events' => ['local.create', 'remote.delete'],
            'rules'  => [],
        ],

        'reports' => [
            'model'   => '',
            'table'   => 'reports',
            'queues'  => [
                'set' => FALSE,
                'get' => TRUE,
            ],
            'events ' => ['local.create', 'remote.delete'],
            'rules'  => [],
        ],
    ],
];
