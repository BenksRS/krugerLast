<?php

namespace Modules\Referrals\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\Referrals\Entities\Referral;

class Followup extends Component
{
    public $referral;
    public function mount(Referral $referral)
    {

        $this->referral = $referral;
    }
    public function render()
    {
        return view('referrals::livewire.show.tabs.followup');
    }
}
