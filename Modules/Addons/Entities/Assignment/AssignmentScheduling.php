<?php

namespace Modules\Addons\Entities\Assignment;

use Modules\Core\Entities\CoreModel;

class AssignmentScheduling extends CoreModel {

	protected $table = 'assignment_schedules';

	protected $fillable = ['assignment_id', 'tech_id', 'created_by', 'updated_by', 'started_at', 'ended_at'];

	protected $casts = [
		'started_at' => 'timestamp',
		'ended_at'   => 'timestamp',
	];

}