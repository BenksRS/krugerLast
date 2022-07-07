<?php

namespace Modules\Addons\Entities\Assignment;

use Modules\Core\Entities\CoreModel;

class AssignmentStatusLog extends CoreModel {

	protected $table = 'assignment_status_logs';

	protected $fillable = ['assignment_id', 'status_id', 'created_by'];

}