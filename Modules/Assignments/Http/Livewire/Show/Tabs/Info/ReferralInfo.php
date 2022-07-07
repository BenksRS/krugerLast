<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Info;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Referrals\Entities\Referral;

class ReferralInfo extends Component
{
    public $show = true;
    protected $listeners = [
        'jobtypeUpdate' => 'processJobtype',
        'referralUpdate' => 'processReferral',
        'editReferralinfo' => 'edit',
    ];
    public $assignment;
    public $carrier;

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
        $this->referral_type_id = $this->assignment->referral->referral_type_id;
        $this->date_of_loss = $this->assignment->dol_date;
        $this->adjuster_info = $this->assignment->adjuster_info;
        $this->carrier_info = $this->assignment->carrier_info;
        $this->claim_number = $this->assignment->claim_number;

        $this->referralList =  Referral::get(['id', 'company_entity', 'company_fictitions'])
            ->pluck("full_name", "id")
            ->toArray();

        $this->validCarrierList($this->assignment->referral_id);

    }
    public function togglePolling()
    {
        $this->polling = !$this->polling;
    }

    public function validCarrierList($referral_id){
        $this->referral = Referral::find($referral_id);

        if($this->referral->referral_type_id == 9){

            $this->carrierList = $this->referral->carriers;

        }else{

            $this->carrierList = [];
        }


//        dd($this->carrierList );
    }
    public function edit(){

        $this->show = !$this->show;

    }
    public function updated($field)
    {
        if ($field == 'referral_id')
        {

            $this->referral= Referral::find($this->referral_id);
            $this->referral_type_id = $this->referral->referral_type_id;

            $this->emit('referralUpdate', $this->referral_id);
        }
    }
    public function processReferral($id){
        $this->referral = Referral::find($id);
        $this->referral_type_id = $this->referral->referral_type_id;
        $this->validCarrierList($id);

    }
    public function processJobtype($id){
        $this->assignment = Assignment::find($id);
    }
    public function update($formData){
       $this->validate();

//dd($formData);
       if($formData['date_of_loss']){
           $formData['date_of_loss'] = Carbon::createFromFormat('m/d/Y', $formData['date_of_loss'])->format('Y-m-d H:i:s');
       }
//       dd($formData['date_of_loss']);
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
