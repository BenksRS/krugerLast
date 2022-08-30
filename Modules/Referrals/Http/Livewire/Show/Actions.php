<?php

namespace Modules\Referrals\Http\Livewire\Show;

use Livewire\Component;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralAuthorizationPivot;
use Modules\Referrals\Entities\ReferralCarriersPivot;

class Actions extends Component
{
    protected $listeners = [
        'checkAuthorizations'
    ];
    public $referral;
    public $rulesCarriers;



    public function mount(Referral $referral)
    {
        $this->referral = $referral;
        $this->checkAuthorizations($this->referral->id);
        $this->checkCarrierDefault();

    }

    public function checkCarrierDefault(){
        $ref_id= $this->referral->id;
        $ref_type_id= $this->referral->referral_type_id;

        $carrier_default = ($ref_type_id == 9) ? 583 :582 ;

        $rule_carrier = ReferralCarriersPivot::where('referral_vendor_id',$ref_id)->where('referral_carrier_id',$carrier_default)->first();

        if(!$rule_carrier){
            ReferralCarriersPivot::create([
                'referral_vendor_id' => $ref_id,
                'referral_carrier_id' => $carrier_default
            ])->save();
        }


    }
    public function checkAuthorizations($referral_id)
    {
//        dd('aqui');
        $this->referral = Referral::find($referral_id);
        $this->rulesCarriers = $this->referral->carriers;
        $message="";
        foreach ($this->rulesCarriers as $carrier){
            $auths_total=ReferralAuthorizationPivot::where('referral_id', $this->referral->id)->get();


            // AUTH NEEDED - YES
            if($carrier->pivot->auth == 'Yes'){
                // USE DEFAULT - YES
                $referral=Referral::find($this->referral->id);
                if($carrier->pivot->default == 'Yes'){

                    $auths_default=count($auths_total->where('carrier_id', $this->referral->id));
                    $auths_carier=count($auths_total->where('carrier_id', $carrier->id));
                    $sum_total_auths=$auths_default+$auths_carier;
//dd($sum_total_auths);
                      if ($sum_total_auths == 0){
                          if(empty($message) ){
                              $message= "<b> MISSING AUTHORIZATIONS SETUP</b><br><br>";
                          }
                          $message="$message # Referral <b>$referral->full_name</b> carrier <b>$carrier->full_name</b>  has no authorization setup! <br>";
                      }

                }else{
                    // USE DEFAULT - NO
                    if (count($auths_total->where('carrier_id', $carrier->id)) == 0){
                        if(empty($message) ){
                            $message= "<b> MISSING AUTHORIZATIONS SETUP</b><br><br>";
                        }
                        $message="$message # Referral <b>$referral->full_name</b> carrier <b>$carrier->full_name</b>  has no authorization setup! <br>";
                    }

                }





            }


        }

        if($message){
            session()->flash('alertAuth' ,[
                'class' => 'danger',
                'message' => $message
            ]);
        }


    }
    public function render()
    {
        return view('referrals::livewire.show.actions');
    }
}
