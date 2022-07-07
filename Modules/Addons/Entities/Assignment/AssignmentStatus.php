<?php

namespace Modules\Addons\Entities\Assignment;

use Modules\Core\Entities\CoreModel;

class AssignmentStatus extends CoreModel {

	protected $table = 'assignment_status';

	protected $fillable = ['name', 'ordem', 'styles', 'active'];

}