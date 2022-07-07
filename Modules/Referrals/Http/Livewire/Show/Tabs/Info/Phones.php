<?php

namespace Modules\Referrals\Http\Livewire\Show\Tabs\Info;

use Livewire\Component;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralPhone;

class Phones extends Component
{
    public $referral;
    public $referralPhones;

    public $contact;
    public $phone;

    public $edit_id = null;
    public $phone_edit = null;
    public $contact_edit = null;

    public function mount(Referral $referral)
    {
        $this->referral = $referral;
        $this->contact = null;
        $this->phone = null;

    }

    public function editPhone($edit_id){
        $this->edit_id = $edit_id;

        $this->referral = Referral::find($this->referral->id);

        $PhonesInfo = ReferralPhone::find($edit_id);
        $this->phone_edit = $PhonesInfo->phone;
        $this->contact_edit = $PhonesInfo->contact;

    }
    public function update(){


        $referralPhone =  ReferralPhone::find($this->edit_id);
        $referralPhone->update([
            "contact" => $this->contact_edit,
            "phone" => $this->phone_edit,

        ]);

        $this->referral = Referral::find($this->referral->id);

        $this->edit_id = null;
        $this->contact_edit = null;
        $this->phone_edit = null;
    }

    public function deletePhone($id_delete){
        $phoneDelete = ReferralPhone::findorfail($id_delete);
        $phoneDelete->delete();



        $this->referral = Referral::find($this->referral->id);


    }
    public function addPhone(){

      ReferralPhone::create([
            'referral_id' => $this->referral->id,
            'phone' => $this->phone,
            'contact' =>$this->contact,
        ])->save();


            $this->contact = $this->phone = '';
            $this->referral = Referral::find($this->referral->id);



    }

    public function render()
    {
        return view('referrals::livewire.show.tabs.info.phones');
    }
}
