<?php

namespace Modules\Referrals\Http\Livewire\Show\Tabs\Carriers;

use Livewire\Component;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralCarriersPivot;

class Pivot extends Component
{


    public $referral;
    public $carriersList;
    public $editCarrier;

    public $default_auth;
    public $auth_needed;

    protected $listeners = [
      'pivotUpdate' => 'processPivot'
    ];


    public function mount(Referral $referral)
    {
        $this->referral = $referral;

        $this->carriersList = $referral->carriers;

    }
    public function processPivot($id){
        $this->referral = Referral::find($id);
        $this->carriersList = $this->referral->carriers;

    }

    public function editcarrier($carrier_id){

        $carrierConfig=ReferralCarriersPivot::where('referral_vendor_id', $this->referral->id)->where('referral_carrier_id', $carrier_id)->first();
        $this->editCarrier = $carrier_id;
        $this->default_auth = $carrierConfig->default;
        $this->auth_needed = $carrierConfig->auth;

        $this->processPivot($this->referral->id);

    }
    public function saveconfig($carrier_id){
        $carrierConfig=ReferralCarriersPivot::where('referral_vendor_id', $this->referral->id)->where('referral_carrier_id', $carrier_id)->first();

        $system_ids=array(582,583);
        if(!in_array($carrier_id, $system_ids) ){
            $update=[
                'auth' => $this->auth_needed,
                'default' => $this->default_auth
            ];
        }else{
            $update=[
                'auth' => $this->auth_needed
            ];
        }


        $carrierConfig->update($update);
        $this->processPivot($this->referral->id);
        $this->editCarrier = $this->default_auth = $this->auth_needed = null;

        $this->emit('checkAuthorizations',$this->referral->id);

    }
    public function removeCarrier($carrier_id){
        $this->referral->carriers()->detach($carrier_id);

        $this->processPivot($this->referral->id);

        $this->emit('carrierUpdate',$this->referral->id);
        $this->emit('checkAuthorizations',$this->referral->id);
    }
    public function render()
    {
        return view('referrals::livewire.show.tabs.carriers.pivot');
    }
}
