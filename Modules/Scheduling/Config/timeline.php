<?php

return [

    'day' => [
        'min'      => '00:00:00',
        'max'      => '24:00:00',
        'scroll'   => '08:00:00',
        'interval' => 60,
    ],

    'format' => [
        'toolbar'  => 'd F, Y',
        'time'     => 'H:i:s',
        'datetime' => 'Y-m-d H:i:s',
        'meridiem' => [
            'time'   => 'h:i',
            'period' => 'A',
        ],
    ],

    'addresses' => [
        'boca'      => [
            'id'      => 1,
            'name'    => 'Boca',
            'street'  => '456 Northwest 35th Street',
            'city'    => 'Boca Raton',
            'state'   => 'FL',
            'zipcode' => '33073',
            'default' => FALSE,
        ],
        'ocala'     => [
            'id'      => 2,
            'name'    => 'Ocala',
            'street'  => '2611 SE 66th St',
            'city'    => 'Ocala',
            'state'   => 'FL',
            'zipcode' => '34480',
            'default' => TRUE,
        ],
        'pensacola' => [
            'id'      => 3,
            'name'    => 'Pensacola',
            'street'  => '4500 N Palafox St',
            'city'    => 'Pensacola',
            'state'   => 'FL',
            'zipcode' => '32505',
            'default' => FALSE,
        ],
        'laplace'   => [
            'id'      => 4,
            'name'    => 'Laplace',
            'street'  => '328 Elm St',
            'city'    => 'Laplace',
            'state'   => 'FL',
            'zipcode' => '70068',
            'default' => FALSE,
        ]
    ]
];
