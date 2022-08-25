<?php

return [
    'name' => 'Menu',

    'only_paths' => [
        'modules' => ['dashboard', 'referrals', 'assignments', 'reports'],
        'methods' => ['index', 'list', 'new', 'create', 'show', 'edit', 'update', 'destroy'],
    ],


    'navbar' => [
        [
            'order'    => 1,
            'name'     => 'dashboard',
            'text'     => 'Dashboard',
            'icon'     => 'bx bx-home-circle',
            'children' => [
                [
                    'text'  => 'Home',
                    'route' => 'dashboard.index',
                ],
                [
                    'text'  => 'Open Jobs',
                    'route' => ['dashboard.list', ['type' => 'open']],
                ],
                [
                    'text'  => 'Ready to bill',
                    'route' => ['dashboard.list', ['type' => 'readytobill']],
                ],
            ],
        ],
        [
            'order'    => 2,
            'name'     => 'assignments',
            'text'     => 'Assignments',
            'icon'     => 'bx bx-file',
            'children' => [
                [
                    'text'  => 'New',
                    'route' => 'assignments.new',
                ],
                [
                    'text'  => 'List',
                    'route' => 'assignments.index',
                ],
            ],
        ],
        [
            'order' => 3,
            'name'  => 'scheduling',
            'text'  => 'Scheduling',
            'route' => 'schedulling.index',
            'icon'  => 'bx bx-grid',
        ],
        [
            'order'    => 4,
            'name'     => 'referrals',
            'text'     => 'Referral',
            'icon'     => 'bx bxs-business',
            'children' => [
                [
                    'text'  => 'New',
                    'route' => 'referrals.new',
                ],
                [
                    'text'  => 'List',
                    'route' => 'referrals.index',
                ],
            ],
        ],
        [
            'order'    => 5,
            'name'     => 'collections',
            'text'     => 'Collections',
            'icon'     => 'bx bx-money',
            'children' => [
                [
                    'text'  => 'List',
                    'route' => ['dashboard.list', ['type' => 'collection']],
                ],
                [
                    'text'  => 'Follow Up',
                    'route' => ['dashboard.list', ['type' => 'followup']],
                ],
            ],
        ],
        [
            'order'    => 6,
            'name'     => 'authorizations',
            'text'     => 'Authorizations',
            'icon'     => 'bx bxs-file-pdf',
            'children' => [
                [
                    'text'  => 'List',
                    'route' => 'referrals.authorizations.index',
                ],
            ],
        ],
        [
            'order'    => 7,
            'name'     => 'reports',
            'text'     => 'Reports',
            'icon'     => 'bx bx-list-ol',
            'children' => [
                [
                    'text'  => 'Info',
                    'route' => 'reports.index',
                ],
            ],
        ],
    ],

    'groups' => [
        'admin' => [
            'can' => ['dashboard.index', 'dashboard.show-jobs'],
        ],
    ],

];
