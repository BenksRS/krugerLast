<?php

namespace Callkruger\Api\Support\Providers;

use Callkruger\Api\Database\Observers\ReportObserver;
use Callkruger\Api\Database\Observers\TokenObserver;
use Callkruger\Api\Models\Admin\Report;
use Callkruger\Api\Models\ApiToken;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider {

    /**
     *
     * /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot ()
    {
        ApiToken::observe(TokenObserver::class);
        Report::observe(ReportObserver::class);
    }

}
