<?php

namespace Modules\Charts\Repositories;

use Modules\Assignments\Entities\Assignment;

class AssignmentRepository extends Assignment {

    use ChartRepository;

    protected $table = 'assignments';

    protected $appends = [
        'referral_carrier',
        'referral_carrier_full',
    ];

    protected $with = [];

}