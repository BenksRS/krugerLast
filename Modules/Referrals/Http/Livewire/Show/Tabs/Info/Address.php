<?php

namespace Modules\Referrals\Http\Livewire\Show\Tabs\Info;

use Livewire\Component;
use Modules\Referrals\Entities\Referral;

class Address extends Component
{
    public $show = true;
    public $referral;

    // fields
    public $street;
    public $city;
    public $state;
    public $zipcode;
    public $email;
    public $address_link;
    public $address_target;
    public $address_message;

    protected $rules = [
        'street' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zipcode' => 'required',
        'email' => 'email',
    ];

    public function mount(Referral $referral)
    {
        $this->referral = $referral;
        $this->street = $referral->street;
        $this->city = $referral->city;
        $this->state = $referral->state;
        $this->zipcode = $referral->zipcode;
        $this->email = $referral->email;
        $this->address_link = $referral->address->link;
        $this->address_target = $referral->address->target;
        $this->address_message = $referral->address->message;
    }


    public function edit(){

        $this->show = false;

    }
    public function update($formData){
        $this->validate();

        $errors = $this->getErrorBag();

        $id =  $this->referral->id;
        $update = $this->referral->update($formData);

        $this->referral = Referral::find($id);
        session()->flash('alert' ,[
            'class' => 'success',
            'message' => "Address/E-mail successfully updated.."
        ]);
        $this->address_link = $this->referral->address->link;
        $this->address_target = $this->referral->address->target;
        $this->address_message = $this->referral->address->message;

        $this->show = true;
//        $this->emitTo('referrals::show.tabs-panel', 'refreshTabPanel',['referral' => $id]);
    }
    public function render()
    {
        return view('referrals::livewire.show.tabs.info.address');
    }
}
