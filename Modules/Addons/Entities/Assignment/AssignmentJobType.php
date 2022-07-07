<?php

namespace Modules\Addons\Entities\Assignment;

use Modules\Core\Entities\CoreModel;

class AssignmentJobType extends CoreModel {

	protected $table = 'assignment_job_types';

	protected $fillable = ['assignment_id', 'job_type_id'];

}