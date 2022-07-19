<?php

namespace Callkruger\Api\Handlers\Events;

use Illuminate\Queue\SerializesModels;

class ProviderProcessed {

    use SerializesModels;

    public $data;

    public function __construct (array $data = [])
    {
        $this->data = $data;
    }

}
