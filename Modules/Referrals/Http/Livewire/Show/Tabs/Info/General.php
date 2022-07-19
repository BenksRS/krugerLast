<?php

namespace Modules\Referrals\Http\Livewire\Show\Tabs\Info;

use Livewire\Component;
use Modules\Referrals\Entities\Referral;
use Modules\User\Entities\Marketing;

class General extends Component
{
    public $referral;
    public $marketingList;
    public $marketing_id;
    public $marketingSelected;
    public $edit=false;

    public function mount(Referral $referral){
        $this->referral = $referral;
        $this->marketingSelected = $this->marketing_id = $this->referral->marketing_id;
        $this->marketingList = Marketing::where('active','Y')->get();
    }

    public function updateMarketing(){
        $update['marketing_id']=$this->marketing_id;

        $this->referral->update($update);

        $this->referral = Referral::find($this->referral->id);

        $this->tooglleedit();
    }
    public function tooglleedit(){
        $this->edit=!$this->edit;
    }
    public function render()
    {
        return view('referrals::livewire.show.tabs.info.general');
    }
}
