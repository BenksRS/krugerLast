<?php

namespace Modules\Addons\Entities\Assignment;

use Modules\Core\Entities\CoreModel;

class AssignmentAuthorization extends CoreModel {

	protected $table = 'assignment_authorizations';

	protected $fillable = ['assignment_id', 'authorization_id'];

}