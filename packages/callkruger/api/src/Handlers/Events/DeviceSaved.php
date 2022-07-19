<?php

namespace Callkruger\Api\Handlers\Events;

use Callkruger\Api\Models\ApiConnection;
use Illuminate\Queue\SerializesModels;

class DeviceSaved {

    use SerializesModels;

    /**
     * @var ApiConnection
     */
    public $connection;

    public function __construct (ApiConnection $connection)
    {
        $this->connection = $connection;
    }

}
