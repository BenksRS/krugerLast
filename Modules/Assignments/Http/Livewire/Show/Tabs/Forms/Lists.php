<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Forms;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralAuthorizationPivot;
use Modules\Referrals\Entities\ReferralCarriersPivot;

class Lists extends Component
{

    public $assignment;

    public $authorizations;


    public function mount(Assignment $assignment)
    {

        $this->assignment = $assignment;
        $this->authorizations = $this->assignment->authorizations;


    }

    public function addAuths($carrier_id, $ref_id){

        $auths= ReferralAuthorizationPivot::where('referral_id', $ref_id)->where('carrier_id',$carrier_id)->get();
         foreach ($auths as $auth){
             $this->assignment->authorizations()->attach($auth->referral_authorizathion_id);
         }
    }
    public function reloadForms()
    {
        $ref_id= $this->assignment->referral->id;
        $ref_type_id= $this->assignment->referral->referral_type_id;
        $carrier_default = ($ref_type_id == 9) ? 583 :582 ;
        $carrier_id= isset($this->assignment->carrier_id) ? $this->assignment->carrier_id : $carrier_default;

        $rule_carrier = ReferralCarriersPivot::where('referral_vendor_id',$ref_id)->where('referral_carrier_id',$carrier_id)->first();

        $auths_total=ReferralAuthorizationPivot::where('referral_id',$ref_id)->get();


        if($rule_carrier){
            // AUTH NEEDED - YES
            if($rule_carrier->auth == 'Yes'){

                // remove auths atual
                $this->assignment->authorizations()->detach();

                // ADD carrier Auths
                if($carrier_id != $carrier_default){
                    $this->addAuths($carrier_id, $ref_id);
                }


                // USE DEFAULT - YES
                if($rule_carrier->default == 'Yes'){
                    // ADD default referral

                    $this->addAuths($ref_id, $ref_id);
                }
            }
            $this->assignment = Assignment::find($this->assignment->id);
            $this->authorizations = $this->assignment->authorizations;
        }else{
            $message= "<b>!!! NO AUTHORISATION`S SETUP !!!</b>
            # You need setup in <b>Referrals</b> !!!!";

            session()->flash('reloadForms' ,[
                'class' => 'danger',
                'message' => $message
            ]);

        }


    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.forms.lists', [
            'listAuth' => $this->authorizations
        ]);
    }
}
