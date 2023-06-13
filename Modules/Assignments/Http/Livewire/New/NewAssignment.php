<?php

namespace Modules\Assignments\Http\Livewire\New;

use Livewire\Component;
use Manny\Manny;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Entities\AssignmentsPhones;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Modules\Referrals\Entities\Referral;
use Auth;

class NewAssignment extends Component
{

    protected $listeners = [
        'contentChange' => 'processContent',
        'clearContent'

    ];
    public $allReferrals;
    public $referralSelected;
    public $carrierSelected;
    public $referral;
    public $carrierLists;
    public $showCarrierInfo = false;
    public $showCarrierSelect = false;

    public $jbSelected=[];
    public $jbSelectedSingle;
    public $jobTypes;

    public $event_id;
    public $first_name;
    public $last_name;
    public $street;
    public $city;
    public $state;
    public $zipcode;
    public $phone;
    public $phone_alternative;
    public $email;
    public $notes;

    public $notes_tech;

    public $date_create;
    public $date_dol;
    public $referral_id;
    public $carrier_id;
    public $carrier_info;
    public $claim_info;
    public $adjuster_info;
    public $ref;

    public $user;

    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'street' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zipcode' => 'required',
        'notes' => 'required',
    ];

    public function mount(){
        $this->allReferrals = Referral::where('status', 'ACTIVE')->get();
        $this->jobTypes = AssignmentsJobTypes::where('active', 'y')->get();
        $this->user = Auth::user();

    }
    public function clearContent(){
        $this->first_name = $this->last_name = $this->street = $this->city = $this->state = $this->zipcode = $this->phone = $this->phone_alternative = $this->email = $this->notes = $this->date_create = $this->date_dol = $this->referralSelected = $this->claim_info = $this->carrier_info = $this->carrierSelected = $this->adjuster_info = null;
        $this->carrierLists = $this->jbSelected = [];
    }
    public function selectJobtype($id){
        if (in_array($id, $this->jbSelected)) {
            $this->jbSelected = array_diff($this->jbSelected, array($id));
        } else {
            $this->jbSelected[] = $id;
        }
    }
    public function processContent(){
        $this->carrierLists=[];
        $this->processCarrier($this->referralSelected);

    }

    public function loadReferral(){
        $this->ref = Referral::find($this->referralSelected);
    }
    public function updated($field)
    {
        if ($field == 'referralSelected')
        {
            $this->loadReferral();
            $this->emit('contentChange');
            $this->carrierSelected = $this->carrier_info = null;

        }
        if ($field == 'phone')
        {
            $this->phone = Manny::mask($this->phone, "(111) 111-1111");
        }
        if ($field == 'phone_alternative')
        {
            $this->phone_alternative = Manny::mask($this->phone_alternative, "(111) 111-1111");
        }
    }

    public function addJob($type){
      $this->validate();
        $errors = $this->getErrorBag();

        $data=[
            'event_id' => $this->event_id ?? null,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'street' => $this->street,
            'city' => $this->city,
            'state' => $this->state,
            'zipcode' => $this->zipcode,
            'referral_id' => $this->referralSelected,
            'carrier_id' => $this->carrierSelected,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
            'claim_number' => $this->claim_info,
            'carrier_info' => $this->carrier_info,
            'email' => $this->email,
            'adjuster_info' => $this->adjuster_info,
            'date_assignment' => $this->date_create,
            'status_id' => 1,
            'status_collection_id' => 3,
            'billed_by' => null,
//
//            'phone' => $this->phone,
//            'phone_alternative' => $this->phone_alternative,
//            'job_types' => $this->jbSelected,
        ];

        $created = Assignment::create($data);


        // add job types
        $this->addJobtypes($created->id);

        // add status open
        $this->addStatus($created->id);

        // add notes
        $this->addNotes($created->id);


        if(isset($this->notes_tech)){
            // add tech notes
            $this->addTechNotes($created->id);
        }


        // add phones
        $this->addPhones($created->id);

        if($type == 'next'){
            return redirect()->to('/assignments/new');
        }else{
            return redirect()->to("/assignments/show/$created->id");
        }


    }
    public function addStatus($id){
        AssignmentsStatusPivot::create([
            'assignment_id'=> $id,
            'assignment_status_id'=> 1,
            'created_by'=> $this->user->id,
        ]);
    }
    public function addNotes($id){
        $job = Assignment::find($id);
        $job->notes()->create([
            'text'=> $this->notes,
            'notable_id'=> $id,
            'created_by'=> $this->user->id,
            'notable_type'=>  Assignment::class,
        ]);
    }
    public function addTechNotes($id){
        $job = Assignment::find($id);
        $job->notes()->create([
            'text'=> $this->notes_tech,
            'notable_id'=> $id,
            'type'=> 'tech',
            'created_by'=> $this->user->id,
            'notable_type'=>  Assignment::class,
        ]);
    }
    public function addPhones($id){

        if($this->phone){
            AssignmentsPhones::create([
                'assignment_id' => $id,
                'phone' => $this->phone,
            ])->save();
        }

        if($this->phone_alternative){
            AssignmentsPhones::create([
                'assignment_id' => $id,
                'phone' => $this->phone_alternative,
            ])->save();

        }

    }
    public function addJobtypes($id){
        $job = Assignment::find($id);

        if(count($this->jbSelected) > 0){
            foreach ($this->jbSelected as $jbType){
                $job->job_types()->attach($jbType);
            }
        }

    }

    public function processCarrier($id){
        $this->referral = Referral::find($id);
        $this->carrierLists = $this->referral->carriers;

        if(count($this->carrierLists) > 0){
            $this->showCarrierSelect = true;
            $this->showCarrierInfo = false;
        }else{
            $this->showCarrierSelect = false;
            $this->showCarrierInfo = true;
        }



    }
    public function update($id){

    }
    public function render()
    {
        return view('assignments::livewire.new.new-assignment');
    }

}
