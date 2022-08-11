<?php

namespace Modules\Employees\Repositories;

use Modules\Employees\Entities\EmployeeCommissions;
use Modules\Employees\Scopes\CommissionsScope;

class CommissionsRepository extends EmployeeCommissions
{
        use CommissionsScope;
}