<?php

namespace Modules\Referrals\Http\Livewire\Show\Tabs\Auths;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Notes\Entities\Note;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralAuthorization;
use Modules\Referrals\Entities\ReferralAuthorizationPivot;

class AuthAdd extends Component
{
    use WithPagination;

    protected $listeners = [
        'authAddUpdate' => 'processAuthAddUpdate',
         'changeCarrier' => 'selectCarrier'
    ];
    protected $paginationTheme = 'bootstrap';
    public $referral;
    public $authsPivot;
    public $searchTerm;
    public $carrierSelected;

    public function mount(Referral $referral)
    {
        $this->referral = $referral;
        $this->carrierSelected =  $this->referral->id;



        $this->authlistattach();
    }

    public function authlistattach()
    {
        $this->authsPivot = ReferralAuthorizationPivot::where('referral_id',$this->referral->id)->where('carrier_id', $this->carrierSelected)->pluck('referral_authorizathion_id');
    }
    public function selectCarrier($carrier_id){

        $this->carrierSelected = $carrier_id;
        $this->authlistattach();
    }
    public function processAuthAddUpdate($id){
        $this->referral = Referral::find($id);
        $this->authlistattach();

//        $this->searchTerm='';
        $this->emit('checkAuthorizations',$this->referral->id);
    }
    public function addAuth($auth_id){

        ReferralAuthorizationPivot::create([
            'referral_id'=> $this->referral->id,
            'carrier_id'=> $this->carrierSelected,
            'referral_authorizathion_id'=> $auth_id
        ]);


        $this->referral = Referral::find($this->referral->id);
        $this->authlistattach();
//        $this->searchTerm='';

        $this->emit('authListUpdate',$this->referral->id);


    }
    public function render()
    {


        $list = ReferralAuthorization::whereNotIn('id',$this->authsPivot)
            ->where(function ($sub_query){
                $searchTerm = "%$this->searchTerm%";
                $sub_query->where('name', 'LIKE',$searchTerm)
                    ->orWhere('description', 'LIKE',$searchTerm);
            })
            ->orderBy('name', 'ASC')
            ->paginate(10);



        return view('referrals::livewire.show.tabs.auths.auth-add', [
            'list' => $list
        ]);
    }
}
