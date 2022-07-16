<?php

namespace Callkruger\Api\Support\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;

class EventServiceProvider extends Provider {

    protected $listen = [
        'Callkruger\Api\Handlers\Events\DeviceSaved'          => [
            'Callkruger\Api\Handlers\Listeners\Device\SyncListJobs'
        ],
        'Callkruger\Api\Handlers\Events\DataSaved'            => [
            'Callkruger\Api\Handlers\Listeners\SyncWithService'
        ],
        'Callkruger\Api\Handlers\Events\DataSync'             => [
            'Callkruger\Api\Handlers\Listeners\Firebase\FirebaseSync'
        ],

        'Callkruger\Api\Handlers\Events\ProviderProcessed' => [
            'Callkruger\Api\Handlers\Listeners\SyncProviderData'
        ],
    ];

}
