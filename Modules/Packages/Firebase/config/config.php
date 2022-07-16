<?php

use Callkruger\Api\Models;

return [

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */
    'api'         => [
        'prefix'  => 'api',
        'version' => 'v1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */
    'events'      => [
        'sys' => [],
        'app' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Connections
    |--------------------------------------------------------------------------
    */
    'connections' => [
        'local'   => [],
        'network' => [
            'driver'     => 'firebase',
            'collection' => [
                'flip' => TRUE,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    */
    'models'      => [
        Models\ApiToken::class        => 'tokens',
        Models\Admin\User::class      => 'users',
        Models\Admin\Employee::class  => 'employees',
        Models\Admin\Worker::class    => 'workers',
        Models\Admin\Job\Job::class   => 'jobs',
        Models\Admin\Picture::class   => 'pictures',
        Models\Admin\Signature::class => 'signatures',
        Models\Admin\Report::class    => 'reports',
    ],

    /*
    |--------------------------------------------------------------------------
    | Collections
    |--------------------------------------------------------------------------
    |
    */
    'collections' => [

        /** @collection tokens */
        'tokens'     => [],

        /** @collection employees */
        'employees'  => [],

        /** @collection workers */
        'workers'    => [],

        /** @collection reports */
        'reports'    => [
            'database' => [
                'local'   => [
                    'table'  => 'job_reports',
                    'events' => ['create', 'update', 'delete'],
                ],
                'network' => [
                    'table'  => 'reports',
                    'events' => ['delete'],
                ],
            ],

            'model' => [
                'index'     => ['id_assignment', 'id_job_type'],
                'fillable'  => [],
                'aliases'   => [],
                'relations' => [],
            ],

            'resource' => [
                'job_id'   => 'id_assignment',
                'job_type' => 'id_job_type',
                'report'   => [
                    'elements'       => [
                        'sandbags'       => 'sandbags',
                        'plywood'        => 'plywood',
                        'two_by_eigth'   => 'two_by_eigth',
                        'two_by_twelve'  => 'two_by_twelve',
                        'two_by_sixteen' => 'two_by_sixteen',
                        'infos'          => 'job_info',
                    ],
                    'checklist'      => 'checklist_work',
                    'workers'        => 'workers',
                    'tarp_size'      => 'tarp_size',
                    'report_options' => 'job_report',
                ],
            ],
        ],

        /** @collection pictures */
        'pictures'   => [],

        /** @collection signatures */
        'signatures' => [],

        /** @collection jobs */
        'jobs'       => [
            'database' => [
                'local'   => [
                    'table'   => ['job_list' => Models\Admin\Job\Job::class],
                    'view'    => ['job_view' => Models\Admin\Job\JobView::class],
                    'methods' => ['update'],
                    'clauses' => [
                        [
                            'methods'   => ['update'],
                            'arguments' => [
                                'status' => ['in_progress', 'uploading', 'uploading_pics'],
                            ],
                        ],
                    ],
                ],
                'network' => [
                    'table'   => 'jobs',
                    'methods' => ['create', 'update', 'delete'],
                    'clauses' => [
                        'delete' => [
                            'status' => ['uploading_pics'],
                        ],

                    ],
                ],
            ],

            'model' => [
                'criteria' => ['id'],
                'fillable' => ['status'],

                'attributes' => [
                    'id'     => 'id_assignment',
                    'status' => 'new_status',
                ],

                'relationships' => [
                    'view' => [
                        'foreign_key' => 'id_assignment',
                        'local_key'   => 'id',
                    ],
                ],
            ],

            'resource' => [
                'job_id'               => 'id_assignment',
                'employee_id'          => 'id_employee',
                'employee_name'        => 'technician_name',
                'referral_company'     => 'referral_company',
                'job_type'             => 'job_types_name',
                'email'                => 'email',
                'full_name'            => 'full_name',
                'full_phone'           => 'full_phone',
                'total_authorizations' => 'total_authorizations',
                'docusign_sent'        => 'docusign_sent',
                'event'                => 'event',
                'nojob'                => 'nojob',
                'notes'                => 'note',
                'order'                => 'ordem',
                'created_at'           => 'create_date',
                'scheduled_order_at'   => 'scheduled_order',
                'scheduled_start_time' => 'scheduled_start_time',
                'address'              => [
                    'street'  => 'address',
                    'city'    => 'city',
                    'state'   => 'state',
                    'zipcode' => 'zipcode',
                ],
                'status'               => [
                    'real' => 'status_real',
                    'new'  => 'new_status',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Providers
    |--------------------------------------------------------------------------
    |
    */
    'providers'   => [

        'api_tokens' => [
            'model'  => Models\ApiToken::class,
            'tables' => [
                'local'   => 'api_tokens',
                'network' => 'tokens',
            ],
        ],

        'users' => [
            'model'       => Models\Admin\User::class,
            'auth'        => TRUE,
            'connections' => [
                'local'   => [
                    'table'   => 'users',
                    'actions' => [],
                ],
                'network' => [
                    'table'   => 'users',
                    'actions' => [
                        'create' => TRUE,
                        'update' => TRUE,
                    ],
                ],
            ],
            'attributes'  => [
                'id'          => 'id',
                'employee_id' => 'id_employee',
                'name'        => 'name',
                'username'    => 'email',
                'password'    => 'password',
                'group'       => 'group',
            ],
        ],

/*        'employees' => [
            'model'       => Models\Admin\Employee::class,
            'auth'        => TRUE,
            'connections' => [
                'local'   => [
                    'table'   => 'employees',
                    'actions' => [],
                ],
                'network' => [
                    'table'   => 'employees',
                    'actions' => [
                        'create' => TRUE,
                    ],
                ],
            ],
            'attributes'  => [
                'id'       => 'id',
                'name'     => 'name',
                'username' => 'email',
                'password' => 'password',
            ],
        ],*/

        'workers' => [
            'model'       => Models\Admin\Worker::class,
            'connections' => [
                'local'   => [
                    'table'   => 'workers',
                    'actions' => [],
                ],
                'network' => [
                    'table'   => 'workers',
                    'actions' => [
                        'create' => TRUE,
                    ],
                ],
            ],
            'attributes'  => [
                'id'   => 'id',
                'name' => 'name',
            ],
        ],

/*        'jobs' => [
            'model'       => Models\Admin\Job\Job::class,
            'connections' => [
                'local'   => [
                    'table'        => 'list_jobs_flutter',
                    'table_action' => 'assignments',
                    'actions'      => [
                        'update' => TRUE,
                    ],
                ],
                'network' => [
                    'table'   => 'jobs',
                    'index'   => 'job_id',
                    'actions' => [
                        'create' => TRUE,
                        'update' => TRUE,
                        'delete' => TRUE,
                    ],
                ],
            ],
            'attributes'  => [
                'job_id'               => 'id',
                'employee_id'          => 'id_employee',
                'employee_name'        => 'technician_name',
                'referral_company'     => 'referral_company',
                'job_type'             => 'job_types_name',
                'email'                => 'email',
                'full_name'            => 'full_name',
                'full_phone'           => 'full_phone',
                'total_authorizations' => 'total_authorizations',
                'docusign_sent'        => 'docusign_sent',
                'event'                => 'event',
                'nojob'                => 'nojob',
                'notes'                => 'note',
                'claim'                => 'claim_info',
                'adjuster'             => 'adjuster_info',
                'order'                => 'ordem',
                'created_at'           => 'create_date',
                'scheduled_order_at'   => 'scheduled_order',
                'scheduled_start_time' => 'scheduled_start_time',
                'address'              => [
                    'street'  => 'address',
                    'city'    => 'city',
                    'state'   => 'state',
                    'zipcode' => 'zipcode',
                ],
                'status'               => [
                    'real' => 'status_real',
                    'new'  => 'new_status',
                ],
                'nojob_data'           => [
                    'info' => 'nojob_info',
                ],
            ],
            'keys'        => ['id'],
            'primary'     => 'id',
            'aliases'     => [
                'id_assignment' => 'id',
                'new_status'    => 'status',
            ],
            'clauses'     => [
                'update' => [
                    'status' => ['in_progress', 'uploading', 'uploading_pics'],
                ],
                'delete' => [
                    'status' => ['uploading_pics', 'nojob_review', 'delete'],
                ],

            ],
        ],

        'pictures' => [
            'model'       => Models\Admin\Picture::class,
            'connections' => [
                'local'   => [
                    'chunk'   => 10,
                    'table'   => 'imagesdata',
                    'actions' => [
                        'create' => TRUE,
                    ],
                ],
                'network' => [
                    'table'   => 'pictures',
                    'actions' => [
                        'delete' => TRUE,
                    ],
                ],
            ],
            'attributes'  => [
                'id'     => 'img_id',
                'file'   => 'b64',
                'job_id' => 'assignment_id',
                'type'   => 'type',
                'label'  => 'label',
            ],
        ],

        'signatures' => [
            'model'       => Models\Admin\Signature::class,
            'connections' => [
                'local'   => [
                    'table'   => 'signdata',
                    'actions' => [
                        'create' => TRUE,
                        'update' => TRUE,
                        'delete' => TRUE,
                    ],
                ],
                'network' => [
                    'table'   => 'signatures',
                    'actions' => [
                        'delete' => TRUE,
                    ],
                ],
            ],
            'attributes'  => [
                'id'          => 'img_id',
                'file'        => 'b64',
                'job_id'      => 'assignment_id',
                'uploaded_at' => 'uploaded_at',
            ],
        ],

        'reports' => [
            'model'       => Models\Admin\Report::class,
            'connections' => [
                'local'   => [
                    'table'   => 'job_reports',
                    'actions' => [
                        'create' => TRUE,
                        'update' => TRUE,
                        'delete' => TRUE,
                    ],
                ],
                'network' => [
                    'table'   => 'reports',
                    'actions' => [
                        'delete' => TRUE,
                    ],
                ],
            ],
            'keys'        => ['id_assignment', 'id_job_type'],
            'attributes'  => [
                'job_id'   => 'id_assignment',
                'job_type' => 'id_job_type',
                'report'   => [
                    'checklist'      => 'checklist_work',
                    'elements'       => [
                        'sandbags'       => 'sandbags',
                        'infos'          => 'job_info',
                        'plywood'        => 'plywood',
                        'two_by_eigth'   => 'two_by_eigth',
                        'two_by_twelve'  => 'two_by_twelve',
                        'two_by_sixteen' => 'two_by_sixteen',
                        'pitch'          => 'pitch',
                    ],
                    'tarp_situation' => [
                        'value'  => 'job_report',
                        'option' => 'tarp_situation',
                    ],
                    'report_options' => 'job_report',
                    'workers'        => 'workers',
                    'tarp_size'      => 'tarp_size',
                ],
            ],
            'relations'   => [
                'tarp_size' => 'tarp_size',
            ],
        ],

        'tarp_size' => [
            'model'       => Models\Admin\Report\TarpSize::class,
            'connections' => [
                'local'   => [
                    'table'   => 'tarp_size_job',
                    'tables'  => [
                        'read'  => 'job_reports',
                        'write' => 'job_reports',
                    ],
                    'actions' => [],
                ],
                'network' => [],
            ],
            'attributes'  => [
                'height'   => 'heigth',
                'width'    => 'length',
                'quantity' => 'value',
                'stock'    => 'stock_id',
            ],
        ],*/
    ],

];
