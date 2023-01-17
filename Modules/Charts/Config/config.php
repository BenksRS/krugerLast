<?php

return [
    'name' => 'Charts',

    'date_group' => [
        'daily'   => [
            'label'    => 'Daily',
            'format'   => 'Y-m-d',
            'interval' => 'P1D',
        ],
        'weekly'  => [
            'label'    => 'Weekly',
            'format'   => 'Y-W',
            'interval' => 'P1W',
        ],
        'monthly' => [
            'label'    => 'Monthly',
            'format'   => 'Y-m',
            'interval' => 'P1M',
        ],
        'yearly'  => [
            'label'    => 'Yearly',
            'format'   => 'Y',
            'interval' => 'P1Y',
        ],
    ],
];
