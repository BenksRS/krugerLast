<?php

namespace Modules\Referrals\Http\Livewire\New;
use Auth;
use Livewire\Component;
use Manny\Manny;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralPhone;
use Modules\Referrals\Entities\ReferralType;

class NewProspect extends Component
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




    public $company_entity;
    public $company_fictitions;
    public $street;
    public $city;
    public $state;
    public $zipcode;
    public $phone;
    public $phone_alternative;
    public $email;
    public $notes;

    public $referral_type_id;
    public $status;

    public $user;

    protected $rules = [
        'company_entity' => 'required',
        'company_fictitions' => 'required',
        'street' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zipcode' => 'required',
        'notes' => 'required',
    ];

    public function mount(){
        $this->allReferrals = Referral::all();
        $this->referral_types = ReferralType::where('active', 'y')->get();
        $this->user = Auth::user();
//        dd( $this->user->id);
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

    public function updated($field)
    {
        if ($field == 'referralSelected')
        {
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

    public function addRef($type){
        $this->validate();
        $errors = $this->getErrorBag();

        $data=[
            'company_entity' => $this->company_entity,
            'company_fictitions' => $this->company_fictitions,
            'street' => $this->street,
            'city' => $this->city,
            'state' => $this->state,
            'zipcode' => $this->zipcode,
            'email' => $this->email,
            'status' => 'LEED',
            'referral_type_id' => 12,
            'marketing_id' => $this->user->id,
        ];

        $created = Referral::create($data);


        // add notes
        $this->addNotes($created->id);

        // add phones
        $this->addPhones($created->id);

        if($type == 'next'){
            return redirect()->to('/referrals/new');
        }else{
            return redirect()->to("/referrals/show/$created->id");
        }


    }

    public function addNotes($id){
        $job = Referral::find($id);
        $job->notes()->create([
            'text'=> $this->notes,
            'notable_id'=> $id,
            'created_by'=> $this->user->id,
            'notable_type'=>  Referral::class,
        ]);
    }
    public function addPhones($id){

        if($this->phone){
            ReferralPhone::create([
                'referral_id' => $id,
                'phone' => $this->phone,
            ])->save();
        }

        if($this->phone_alternative){
            ReferralPhone::create([
                'referral_id' => $id,
                'phone' => $this->phone_alternative,
            ])->save();
        }

    }


    public function update($id){

    }
    public function render()
    {
        return view('referrals::livewire.new.new-prospect');
    }
}
