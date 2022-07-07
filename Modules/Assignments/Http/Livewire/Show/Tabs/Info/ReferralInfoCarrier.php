<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Info;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Referrals\Entities\Referral;

class ReferralInfoCarrier extends Component
{
    protected $listeners = [
        'referralUpdate' => 'processReferral',
    ];
    public $assignment;
    public $referral;
    public $carrierList = [];
    public $carrierInfo = 'none';

    public function mount(Assignment $assignment, Referral $referral)
    {
        $this->assignment = $assignment;
        $this->referral = $referral;

        $this->validCarrierList($this->referral->id);
    }
    public function processReferral($id){
        $this->referral = Referral::find($id);
        $this->validCarrierList($id);
    }
    public function validCarrierList($referral_id){
        $this->referral = Referral::find($referral_id);

        $this->carrierInfo = 'antes';
        if($this->referral->referral_type_id == 9){

            $this->carrierList = $this->referral->carriers;
            $this->carrierInfo = 'before';
        }
    }

    public function render()
    {
        return view('assignments::livewire.show.tabs.info.referral-info-carrier');
    }
}
