<?php

namespace Modules\Referrals\Repositories;

use Carbon\Carbon;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Scopes\ReferralsScope;

class ReferralsRepository extends Referral{

    use ReferralsScope;

    protected $with = ['authorizathions', 'type'];
    protected $appends = ['jobs_sent', 'days_last_job'];

    public function getJobsSentAttribute (){

        $return = "N";
        if($this->lastjob){
            $return = "Y";
        }
        return $return;
    }
    public function getDaysLastJobAttribute (){

        $return = "-";
        if($this->lastjob){

            $date_last = new \DateTime($this->lastjob->created_date);

            $today=Carbon::now();
            $days_from_last_job = $date_last->diff($today);
            $return = $days_from_last_job->format('%a');
//            dd($return);
        }
        return $return;
    }

}
