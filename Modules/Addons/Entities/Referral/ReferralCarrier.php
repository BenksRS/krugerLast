<?php

namespace Modules\Addons\Entities\Referral;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\CoreModel;

class ReferralCarrier extends CoreModel {

	protected $table = 'referral_carriers';

	protected $fillable = ['referral_id', 'carrier_id'];

}