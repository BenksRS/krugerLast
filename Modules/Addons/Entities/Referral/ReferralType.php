<?php

namespace Modules\Addons\Entities\Referral;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\CoreModel;

class ReferralType extends CoreModel {

	protected $table = 'referral_types';

	protected $fillable = ['name', 'active'];

	public function referrals2 ()
	{
		return $this->hasMany(Referral::class, 'type_id');
	}

	public function referrals ()
	{
		return $this->morphToMany(Referral::class, 'storable');
	}

	public function storable ()
	{
		return $this->morphTo();
	}



}