<?php

namespace Callkruger\Api\Models\Admin;

use Callkruger\Api\Models\ApiModel;
use Callkruger\Api\Support\Traits\Relations\RelationService;

class Worker extends ApiModel {

    use RelationService;

    protected $provider   = 'workers';

}
