<?php

namespace Modules\Referrals\Http\Livewire\Pages;

use Livewire\Component;
use Modules\Referrals\Entities\Referral;

class ShowReferrals extends Component
{



    public function render()
    {
        $referrals = Referral::all();

        return view('referrals::livewire.pages.show-referrals',[
            'referrals' => $referrals
        ]);
    }
}
