<?php

namespace Modules\Referrals\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralBilling;

class Billing extends Component
{

    public $showBilling=true;

    public $referral;
    public $referralBilling;

    public $days_from_billing;
    public $days_from_scheduling;
    public $days_from_scheduling_lien;
    public $description;


    public function mount(Referral $referral)
    {

        $this->referral = $referral;
        $this->referralBilling = ReferralBilling::where('referral_id',$this->referral->id)->first();
        if($this->referralBilling){
            $this->days_from_billing = $this->referralBilling->days_from_billing;
            $this->days_from_scheduling = $this->referralBilling->days_from_scheduling;
            $this->days_from_scheduling_lien = $this->referralBilling->days_from_scheduling_lien;
            $this->description = $this->referralBilling->description;
        }


    }

    public function addNewNote(){

        $update=[
            'days_from_billing' => $this->days_from_billing,
            'days_from_scheduling' => $this->days_from_scheduling,
            'days_from_scheduling_lien' => $this->days_from_scheduling_lien,
            'description' => $this->description
        ];
        $this->referralBilling->update($update);
        $this->referralBilling = ReferralBilling::where('referral_id',$this->referral->id)->first();
        $this->showBilling = !$this->showBilling;
    }
    public function edit(){
        $this->showBilling = !$this->showBilling;
    }
    public function checkRefBilling(){

    }
    public function render()
    {
        return view('referrals::livewire.show.tabs.billing');
    }
}
