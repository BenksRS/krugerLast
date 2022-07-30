<?php

namespace Modules\Referrals\Http\Livewire\Show\Tabs\Info;

use Livewire\Component;
use Modules\Referrals\Entities\Referral;
use Auth;

class Notes extends Component
{
    public $referral;
    public $notesList;
    public $user;
    public $notetext;
    public $showinfo = false;



    public function mount(Referral $referral)
    {
        $this->referral = $referral;
        $this->notesList = $this->referral->notes;
        $this->user = Auth::user();


    }

    public function showAdd(){
        $this->showinfo = true;
    }
    public function addNewNote(){


        $this->referral->notes()->create([
            'text'=> $this->notetext,
            'notable_id'=> $this->referral->id,
            'created_by'=> $this->user->id,
            'notable_type'=>  Referral::class,
        ]);

        $this->notetext = null;
        $this->showinfo = false;

        $this->referral = Referral::find($this->referral->id);
//        sleep(0.5);
        $this->notesList = $this->referral->notes;

    }
    public function render()
    {

        return view('referrals::livewire.show.tabs.info.notes', [
            'notesListAll' => $this->notesList,
            'show' => $this->showinfo,
        ]);
    }



}
