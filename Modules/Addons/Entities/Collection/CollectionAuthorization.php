<?php

namespace Modules\Addons\Entities\Collection;

use Illuminate\Database\Eloquent\Model;
use Modules\Addons\Entities\Authorization;
use Modules\Core\Entities\CoreModel;

class CollectionAuthorization extends CoreModel {


	protected $fillable = ['active', 'authorization_id'];

	public function collect()
	{
		return $this->morphTo('collect');
	}

	public function authorization() {
		return $this->hasOne(Authorization::class, 'id', 'authorization_id');
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