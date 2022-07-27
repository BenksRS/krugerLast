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
            'model'  => Repositories\UserRepository::class,
            'table'  => 'users',
            'queues' => [
                'set' => TRUE,
                'get' => FALSE,
            ],
            'events' => [],
            'rules'  => [],
        ],

        'workers' => [
            'model'  => Repositories\WorkerRepository::class,
            'table'  => 'workers',
            'queues' => [
                'set' => TRUE,
                'get' => FALSE,
            ],
            'events' => [],
            'rules'  => [],
        ],

        'assignments' => [
            'model'  => Repositories\AssignmentRepository::class,
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
            'model'  => Repositories\PictureRepository::class,
            'table'  => 'pictures',
            'queues' => [
                'set' => FALSE,
                'get' => TRUE,
            ],
            'events' => ['local.create', 'remote.delete'],
            'rules'  => [],
        ],

        'signatures' => [
            'model'  => Repositories\SignatureRepository::class,
            'table'  => 'signatures',
            'queues' => [
                'set' => FALSE,
                'get' => TRUE,
            ],
            'events' => ['local.create', 'remote.delete'],
            'rules'  => [],
        ],

        'reports' => [
            'model'     => Repositories\Report\ReportRepository::class,
            'relations' => [
                Repositories\Report\ReportReportRepository::class,
                Repositories\Report\ReportTarpSizeRepository::class,
                Repositories\Report\ReportWorkerRepository::class,
            ],
            'table'     => 'reports',
            'queues'    => [
                'set' => FALSE,
                'get' => TRUE,
            ],

            'events' => ['local.create', 'remote.delete'],
            'rules'  => [],
        ],
    ],
];
