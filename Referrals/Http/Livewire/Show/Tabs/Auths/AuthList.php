<?php

namespace Modules\Referrals\Http\Livewire\Show\Tabs\Auths;

use Livewire\Component;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralAuthorizationPivot;
use Modules\Referrals\Repositories\ReferralsRepository;

class AuthList extends Component
{
    public $referral;
    public $listAuth;
    public $carriersList;

    public $carrierSelected;
    public $authorizathions=[];

    protected $listeners = [
        'authListUpdate' => 'processAuth',
        'changeCarrier' => 'selectCarrier'
    ];
    public function mount(Referral $referral)
    {
        $this->referral = $referral;
        $inarray=array(582,583);
        $this->carriersList = $referral->carriers->whereNotIn('id',$inarray);
        $this->carrierSelected =  $this->referral->id;



        $this->listAuth = $referral->authorizathions;
    }
    public function selectCarrier($carrier_id){
        $this->carrierSelected = $carrier_id;
    }
    public function removeAuth($auth_id){

        ReferralAuthorizationPivot::where('referral_id',$this->referral->id)->where('carrier_id',$this->carrierSelected)->where('referral_authorizathion_id', $auth_id)->delete();

        $this->referral = Referral::find($this->referral->id);
        $this->listAuth = $this->referral->authorizathions;
        sleep(0.5);

        $this->emit('authAddUpdate',$this->referral->id);

    }
    public function processAuth($id){
        $this->referral = Referral::find($id);
        $this->listAuth = $this->referral->authorizathions;

        $this->emit('checkAuthorizations',$this->referral->id);
    }
    public function render()
    {
        return view('referrals::livewire.show.tabs.auths.auth-list');
    }
}
