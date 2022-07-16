<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Info;

use Carbon\Carbon;
use Livewire\Component;
use Manny\Manny;
use Modules\Assignments\Entities\Assignment;
use Modules\Referrals\Entities\Referral;

class ReferralInfo extends Component
{
    public $show = true;
    protected $listeners = [
        'jobtypeUpdate' => 'processJobtype',
        'referralUpdate' => 'processReferral',
        'editReferralinfo' => 'edit',
        'contentChange' => 'processContent',
    ];

    public $assignment;
    public $carrier;

    public $referralSelected;
    public $carrierSelected;
    public $carrierLists;
    public $showCarrierSelect = true;

    public $referralList;
    public $carrierList = array();

    public $polling = true;


    public $referral;
    public $pre_referral;
    public $referral_id;
    public $referral_type_id;

    public $carrier_id;
    public $carrier_info;
    public $claim_number;
    public $date_of_loss;
    public $adjuster_info;


    protected $rules = [
        'referral_id' => 'required',
    ];


    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->carrier = $this->assignment->carrier()->first();

        $this->referral_id = $this->assignment->referral->id;
        $this->referralSelected = $this->assignment->referral->id;
        if($this->carrier){
            $this->carrierSelected = $this->carrier->id;
        }


        $this->referral_type_id = $this->assignment->referral->referral_type_id;
        $this->date_of_loss = $this->assignment->date_of_loss;
        $this->adjuster_info = $this->assignment->adjuster_info;
        $this->carrier_info = $this->assignment->carrier_info;
        $this->claim_number = $this->assignment->claim_number;

        $this->allReferrals = Referral::all();

        $this->processCarrier($this->referral_id);
//        $this->validCarrierList($this->assignment->referral_id);

    }


    public function processContent(){
        $this->carrierLists=[];
        $this->processCarrier($this->referralSelected);

    }
    public function togglePolling()
    {
        $this->polling = !$this->polling;
    }
    public function processCarrier($id){
        $this->referral = Referral::find($id);
        $this->carrierLists = $this->referral->carriers;

        if(count($this->carrierLists) > 0){
            $this->showCarrierSelect = true;
        }else{
            $this->showCarrierSelect = false;
        }
    }
    public function validCarrierList($referral_id){
        $this->referral = Referral::find($referral_id);

        $this->carrierList = $this->referral->carriers;

    }
    public function edit(){

        $this->show = !$this->show;

    }
    public function updated($field)
    {
        if ($field == 'referralSelected')
        {
//            dd('aqui');
            $this->emit('contentChange');
        }
    }
    public function processReferral($id){
        $this->referral = Referral::find($id);

        $this->validCarrierList($id);

    }
    public function processJobtype($id){
        $this->assignment = Assignment::find($id);
    }
    public function update($formData){
        $this->validate();

        if($formData['date_of_loss'] == ''){
            $formData['date_of_loss'] = null;
        }

        $errors = $this->getErrorBag();

        $id =  $this->assignment->id;
        $update = $this->assignment->update($formData);


        session()->flash('alert' ,[
            'class' => 'success',
            'message' => "Referral Info successfully updated.."
        ]);
        $this->assignment = Assignment::find($id);
        $this->date_of_loss = $this->assignment->dol_date;
        $this->adjuster_info = $this->assignment->adjuster_info;
        $this->carrier_info = $this->assignment->carrier_info;
        $this->claim_number = $this->assignment->claim_number;

        $this->show = true;
    }
    public function render()
    {
        $this->validCarrierList($this->referral_id);
        return view('assignments::livewire.show.tabs.info.referral-info',[
            'cList' => $this->carrierList
        ]);
    }
}
