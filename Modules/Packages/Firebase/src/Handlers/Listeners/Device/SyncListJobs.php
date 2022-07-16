<?php

namespace Callkruger\Api\Handlers\Listeners\Device;

use Callkruger\Api\Handlers\Events\DeviceSaved;

class SyncListJobs {

    public function __construct ()
    {
        //
    }

    public function handle (DeviceSaved $event)
    {
      return $event->connection->load(['token.tokenable', 'device'])->toJson();
    }

}
