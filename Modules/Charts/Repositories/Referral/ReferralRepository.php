<?php

namespace Modules\Charts\Repositories\Referral;

use Modules\Charts\Repositories\AssignmentRepository;
use Modules\Charts\Repositories\ChartRepository;
use Modules\Referrals\Entities\Referral;

class ReferralRepository extends Referral {

    use ChartRepository;

    protected $table = 'referrals';

    public function assignments ()
    {
        return $this->hasMany(AssignmentRepository::class, 'referral_id');
    }

    public function carriers()
    {
        return $this->belongsToMany(ReferralRepository::class,'referral_carriers_pivots','referral_vendor_id','referral_carrier_id','id')->withPivot('auth', 'default');
    }


}