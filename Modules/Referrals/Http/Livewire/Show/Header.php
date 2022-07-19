<?php

namespace Modules\Referrals\Http\Livewire\Show;

use Livewire\Component;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralType;
use Auth;

class Header extends Component
{

    public $show = true;
    public $referral;
    public $types;

    // var class css
    public $status_class;

    // fields
    public $company_entity;
    public $company_fictitions;
    public $referral_type_id;
    public $status;
    public $user;


    protected $rules = [
        'company_entity' => 'required',
        'company_fictitions' => 'required',
        'referral_type_id' => 'required',
        'status' => 'required',
    ];

    public function mount(Referral $referral){


        $this->referral = $referral;

        $this->company_entity = $referral->company_entity;
        $this->company_fictitions = $referral->company_fictitions;
        $this->referral_type_id = $referral->referral_type_id;
        $this->status = $referral->status;
        $this->user = Auth::user();

        $this->types = ReferralType::all();

        // create class css
        $this->status_class="bg-".strtolower(str_replace(" ", "_",  $this->referral->status));


    }


    public function edit(){

        $this->show = false;


    }
    public function update($formData){
        $this->validate();


        $errors = $this->getErrorBag();

        $id =  $this->referral->id;
//        $formData
//        $formData->merge(['updated_by' => $this->user->id]);
        $formData['updated_by']=$this->user->id;
//        dd($formData);
        $update = $this->referral->update($formData);

        $this->referral = Referral::find($id);
        session()->flash('alert' ,[
            'class' => 'success',
            'message' => "Referral #$id successfully updated.."
        ]);



//        dd($errors->any());
        $this->show = true;
        $this->emitTo('referrals::show.tabs-panel', 'refreshTabPanel',['referral' => $id]);
    }

    public function render()
    {

        return view('referrals::livewire.show.header');

    }

}
