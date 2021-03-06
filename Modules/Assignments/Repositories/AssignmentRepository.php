<?php

namespace Modules\Assignments\Repositories;

use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Scopes\AssignmentScope;

class AssignmentRepository extends Assignment {

    use AssignmentScope;

    protected $with    =['scheduling','referral','carrier','status','event','phones','user_updated','user_created','job_types'];

    protected $appends = ['origin_address'];

    public function __construct ()
    {
        parent::__construct();
    }


    public function getOriginAddressAttribute ()
    {
        return sprintf("%s, %s, %s %s", ucwords(strtolower($this->street)), ucwords(strtolower($this->city)), $this->state, $this->zipcode);
    }

}
//->addOrigin('456 NW 35th St, Boca Raton, FL 33431, US')