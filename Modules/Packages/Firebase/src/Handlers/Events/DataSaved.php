<?php

namespace Callkruger\Api\Handlers\Events;

use Illuminate\Queue\SerializesModels;

class DataSaved {

    use SerializesModels;

    public $model;

    public function __construct ($model)
    {
        $this->model = $model;
    }

}
