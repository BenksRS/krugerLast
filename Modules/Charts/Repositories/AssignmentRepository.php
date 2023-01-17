<?php

namespace Modules\Charts\Repositories;

use Modules\Assignments\Entities\Assignment;

class AssignmentRepository extends Assignment {

    use ChartRepository;

    protected $table = 'assignments';

}