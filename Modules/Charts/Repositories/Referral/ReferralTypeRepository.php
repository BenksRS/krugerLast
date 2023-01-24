<?php

namespace Modules\Charts\Repositories\Referral;

use Modules\Charts\Repositories\ChartRepository;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralType;

class ReferralTypeRepository extends ReferralType {

    use ChartRepository;

    protected $table = 'referral_types';

    public function referrals()
    {
        return $this->hasMany(ReferralRepository::class, 'referral_type_id');
    }

    public function assignments()
    {
        return $this->hasManyThrough(
            'Modules\Charts\Repositories\AssignmentRepository',
            'Modules\Charts\Repositories\Referral\ReferralRepository',
            'referral_type_id',
            'referral_id',
            'id',
            'id'
        );
    }

}