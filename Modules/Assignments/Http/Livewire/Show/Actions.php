<?php

namespace Modules\Assignments\Http\Livewire\Show;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Auth;
use Modules\Assignments\Entities\AssignmentFinance;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralAuthorizationPivot;
use Modules\Referrals\Entities\ReferralCarriersPivot;

class Actions extends Component
{
    protected $listeners = [
        'checkFinance',
        'changeStatus'
    ];
    public $user;
    public $assignment;
    public $invoices;
    public $dateupdate='?';

    public function mount(AssignmentFinanceRepository $assignment)
    {
        $this->assignment = $assignment;
        $this->user = Auth::user();



//        dd($assignment->finance);
        $this->checkFinance();
        $this->checkAuthorizations();

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


        }


    }
    public function addAuths($carrier_id, $ref_id){

        $auths= ReferralAuthorizationPivot::where('referral_id', $ref_id)->where('carrier_id',$carrier_id)->get();
        foreach ($auths as $auth){
            $this->assignment->authorizations()->attach($auth->referral_authorizathion_id);
        }
    }
    public function checkHasAuthorizations(){
        $message="";
        $total_auths=$this->assignment->authorizations;

        $this->reloadForms();

//        if(count($total_auths) == 0){
//            $message= "<b>!!! NO AUTHORISATION`S FOUND FOR THIS JOB !!!</b>
//            Please check Forms!";
//        }
//
//        if($message){
//            session()->flash('hasAuth' ,[
//                'class' => 'danger',
//                'message' => $message
//            ]);
//        }
    }
    public function checkAuthorizations(){
        $ref_id= $this->assignment->referral->id;
        $ref_type_id= $this->assignment->referral->referral_type_id;
        $carrier_default = ($ref_type_id == 9) ? 583 :582 ;
        $carrier_id= isset($this->assignment->carrier_id) ? $this->assignment->carrier_id : $carrier_default;

        $rule_carrier = ReferralCarriersPivot::where('referral_vendor_id',$ref_id)->where('referral_carrier_id',$carrier_id)->first();

        $auths_total=ReferralAuthorizationPivot::where('referral_id',$ref_id)->get();
        $message="";
        $messagewarning="";
        // AUTH NEEDED - YES

        if($rule_carrier){
            if($rule_carrier->auth == 'Yes'){

                $this->checkHasAuthorizations();

                $carrier=Referral::find($carrier_id);
                $referral=Referral::find($ref_id);

                // USE DEFAULT - YES
                if($rule_carrier->default == 'Yes'){


                    $auths_default=count($auths_total->where('carrier_id', $ref_id));
                    $auths_carier=count($auths_total->where('carrier_id', $carrier_id));
                    $sum_total_auths=$auths_default+$auths_carier;

                    if ($sum_total_auths == 0){
                        if(empty($message) ){
                            $message= "<b> MISSING AUTHORIZATIONS SETUP</b><br><br>";
                        }

                        $message="$message # Referral <b>$referral->full_name</b> carrier <b>$carrier->full_name</b>  has no authorization setup! <br>";
                    }

                }else{
                    // USE DEFAULT - NO
                    if (count($auths_total->where('carrier_id', $carrier_id)) == 0){
                        if(empty($message) ){
                            $message= "<b> MISSING AUTHORIZATIONS SETUP</b><br><br>";
                        }
                        $message="$message # Referral <b>$referral->full_name</b> carrier <b>$carrier->full_name</b>  has no authorization setup! <br>";
                    }

                }
            }else{
                $messagewarning="<b> THIS JOB DON`T NEED AUTHORIZATION</b>";
            }
        }else{
            $carrier=Referral::find($carrier_id);
            $referral=Referral::find($ref_id);

            if(empty($message) ){
                $message= "<b> CARRIER AND AUTHORIZATHIONS NOT SETUP</b><br><br>";
            }

            $message="$message # Referral <b>$referral->full_name</b> carrier <b>$carrier->full_name</b>  has no authorization setup! <br>";
        }


        if($messagewarning){
            session()->flash('noneed' ,[
                'class' => 'warning',
                'message' => $messagewarning
            ]);
        }
        if($message){
            session()->flash('missingAuth' ,[
                'class' => 'danger',
                'message' => $message
            ]);
        }
    }
    public function checkFinance()
    {
        $status_finance= $this->assignment->finance->balance->status;
        $this->dateupdate = Carbon::now();

//        dd($this->assignment->finance);

        if($status_finance!='pending'){
            $this->changeStatus($status_finance);
        }

    }

    public function changeStatus($newStatus)
    {
        if($this->assignment->status_id != $newStatus){
            AssignmentsStatusPivot::create([
                'assignment_id'=> $this->assignment->id,
                'assignment_status_id'=> $newStatus,
                'created_by'=> 73,
            ]);
            $update_status=[
                'status_id'  => $newStatus,
                'updated_by'  => $this->user->id,
            ];

            $status_collection=array(5,6);
            if(in_array($newStatus, $status_collection)){
                $update_status['status_collection_id']=$newStatus;
            }


            $this->assignment->update($update_status);

            $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);
//            integration()->sync('assignments', $this->assignment->id);
            integration('assignments')->set($this->assignment->id);
            $this->emit('updateScheduling');
        }
    }



    public function render()
    {
        return view('assignments::livewire.show.actions');
    }
}
