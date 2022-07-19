<?php

namespace Callkruger\Api\Models\Admin;

use Callkruger\Api\Models\ApiModel;
use Callkruger\Api\Support\Traits\Relations\RelationService;
use Callkruger\Api\Support\Traits\Relations\RelationToken;

class Employee extends ApiModel {

    use RelationToken;
    use RelationService;

    protected $provider   = 'employees';

}
