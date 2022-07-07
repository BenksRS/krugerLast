<?php

namespace Modules\Addons\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\CoreModel;

class JobType extends CoreModel {

	protected $table = 'job_types';

	protected $fillable = ['name', 'type', 'active'];



}