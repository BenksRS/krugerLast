<?php

namespace Modules\Referrals\Repositories;

use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Scopes\ReferralsScope;

class ReferralsRepository extends Referral{

    use ReferralsScope;

    protected $with = ['authorizathions', 'type'];

}
