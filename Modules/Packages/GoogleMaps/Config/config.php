<?php

/**
 * Set your google api key.
 */

use Modules\Packages\GoogleMaps\Services;

return [

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Will be used for all web services,
    | unless overwritten bellow using 'key' parameter
    |
    |
    */
    'api_key'         => env('GOOGLE_MAPS_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Verify SSL Peer
    |--------------------------------------------------------------------------
    |
    | Will be used for all web services to verify
    | SSL peer (SSL certificate validation)
    |
     */
    'ssl_verify_peer' => TRUE,

    /*
    |--------------------------------------------------------------------------
    | Service URL
    |--------------------------------------------------------------------------
    |
    */
    'service'         => [
        'distancematrix' => [
            'class'    => Services\DistanceMatrix::class,
            'endpoint' => 'https://maps.googleapis.com/maps/api/distancematrix/json',
            'resource' => [
                'key'                        => NULL,
                'origins'                    => NULL,
                'destinations'               => NULL,
                'mode'                       => NULL,
                'avoid'                      => NULL,
                'units'                      => 'imperial',
                'region'                     => 'en',
                'language'                   => 'en',
                'arrival_time'               => NULL,
                'transit_mode'               => NULL,
                'departure_time'             => NULL,
                'transit_routing_preference' => NULL,
            ],
            'response' => [

            ],
        ],
    ],

];
