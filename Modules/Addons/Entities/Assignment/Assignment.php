<?php

namespace Modules\Addons\Entities\Assignment;

use Modules\Addons\Entities\Authorization;
use Modules\Addons\Entities\JobType;
use Modules\Addons\Entities\Referral\Referral;
use Modules\Core\Entities\CoreModel;

class Assignment extends CoreModel {

	protected $table = 'assignments';

	protected $fillable = ['referral_id', 'carrier_id', 'carrier', 'first_name', 'last_name', 'email', 'claim_number', 'infos', 'street', 'city', 'state', 'zipcode', 'created_by', 'updated_by', 'loss_at', 'assigned_at'];

	protected $casts = [
		'infos'       => 'array',
		'loss_at'     => 'datetime',
		'assigned_at' => 'datetime',
	];

	public function referral ()
	{
		return $this->belongsTo(Referral::class, 'referral_id', 'id');
	}

	public function carrier ()
	{
		return $this->belongsTo(Referral::class, 'carrier_id', 'id');
	}

	public function job_types ()
	{
		return $this->hasManyThrough(
			JobType::class,
			AssignmentJobType::class,
			'assignment_id',
			'id',
			'id',
			'job_type_id');
	}

	public function authorizations ()
	{
		return $this->hasManyThrough(
			Authorization::class,
			AssignmentAuthorization::class,
			'assignment_id',
			'id',
			'id',
			'authorization_id');
	}

}