<?php

namespace Modules\Addons\Entities\Referral;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\CoreModel;

class Referral extends CoreModel {

	protected $table = 'referrals';

	protected $fillable = ['type_id', 'company_entity', 'company_fictitions', 'main_contact', 'email', 'street', 'city', 'state', 'zipcode'];

	public function type ()
	{
		return $this->belongsTo(ReferralType::class, 'type_id');
	}

	public function types ()
	{
		return $this->morphedByMany(ReferralType::class, 'storable', 'referral_has_models', 'referral_id', 'model_id');
	}

	public function carriers2 ()
	{
		return $this->hasManyThrough(
			Referral::class,
			ReferralCarrier::class,
			'referral_id',
			'id',
			'id',
			'carrier_id');
	}

	/*	public function authorizations2 ()
		{
			return $this->hasManyThrough(
				Authorization::class,
				ReferralAuthorization::class,
				'referral_id',
				'id',
				'id',
				'authorization_id');
		}*/

}