<?php

namespace Modules\Addons\Entities\Referral;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\CoreModel;

class ReferralAuthorization extends CoreModel {

	protected $table = 'referral_authorizations';

	protected $fillable = ['referral_id', 'authorization_id', 'active'];

}