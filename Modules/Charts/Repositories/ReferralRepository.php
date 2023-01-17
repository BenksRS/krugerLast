<?php

namespace Modules\Charts\Repositories;

use Modules\Referrals\Entities\Referral;

class ReferralRepository extends Referral {

    use ChartRepository;

    protected $table = 'referrals';

    public function assignments ()
    {
        return $this->hasMany(AssignmentRepository::class, 'referral_id');
    }

}