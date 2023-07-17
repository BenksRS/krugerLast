<?php

return [
    'name' => 'Alacrity',

    /**
     * The base URL for the Alacrity API.
     */
//    'base_url' => 'https://em.atst.alacrity.net/WebService/AlacrityService.svc',
    'base_url' => 'https://em.alacrity.net/WebService/AlacrityService.svc',

    /**
     * The credentials used to authenticate with the Alacrity API.
     */
    'credentials' => [
        'username' => env('ALACRITY_USERNAME', 'system@callkruger.com'),
//        test
//        'password' => env('ALACRITY_PASSWORD', 'Pinhal@4776'),
//    producao e Test
        'password' => env('ALACRITY_PASSWORD', 'Kruger@4886'),
        'appName' => env('ALACRITY_APP_NAME', 'Kruger'),
        'version' => env('ALACRITY_VERSION', '1'),
        'token' => env('ALACRITY_TOKEN', '07315C1C-E7E4-458D-BBD2-5ECE3084C5C2'),
    ],


    /**
     * The available services and their endpoints.
     */
    'endpoints' => [
        'signin' => [
            'method' => 'POST',
            'endpoint' => 'SignIn',
        ]
    ],


    'attributes' => [
        'userId' => 'UserId',
        'userSessionId' => 'UserSessionId',
    ],



];
