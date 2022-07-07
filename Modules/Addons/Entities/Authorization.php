<?php

namespace Modules\Addons\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\CoreModel;

class Authorization extends CoreModel {

	protected $table = 'authorizations';

	protected $fillable = ['name', 'description', 'b64'];

	public function collect()
	{
		return $this->morphTo('collect');
	}

/*	public function referrals ()
	{
		return $this->hasManyThrough(
			Referral::class,
			ReferralAuthorization::class,
			'authorization_id',
			'id',
			'id',
			'referral_id');
	}*/

}