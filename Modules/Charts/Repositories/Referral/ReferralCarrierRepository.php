<?php

namespace Modules\Charts\Repositories\Referral;

use Modules\Charts\Repositories\AssignmentRepository;
use Modules\Charts\Repositories\ChartRepository;
use Modules\Referrals\Entities\Referral;

class ReferralCarrierRepository extends Referral {

    use ChartRepository;

    protected $table = 'referrals';


}