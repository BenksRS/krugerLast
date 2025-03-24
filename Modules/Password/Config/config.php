<?php

return [
    'name'       => 'Password',
    'components' => [
        'base' => [
            'is_admin'    => 'N',
            'user_groups' => ['*'],
        ],
        'admin' => [
            'is_admin'    => 'Y',
            'user_groups' => [1],
        ]
    ]
];