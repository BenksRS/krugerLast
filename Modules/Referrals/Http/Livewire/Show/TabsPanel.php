<?php

namespace Modules\Referrals\Http\Livewire\Show;

use Illuminate\View\View;
use Livewire\Component;
use Modules\Referrals\Entities\Referral;

class TabsPanel extends Component
{

    protected $listeners = [
        'changeTab' => 'processChangetab',
        'refreshTabPanel' => '$refresh'

    ];

    public $referral;
    public $isActive = 'authorizations';
    public $navs = [
        [
            'title' => 'Info Details',
            'href' => 'info-details',
            'key' => 'referrals_tab_info',
            'tab' => 'referrals::show.tabs.info',
            'category' => 'all',
        ],
        [
            'title' => 'Carriers',
            'href' => 'carriers',
            'key' => 'referrals_tab_carrier',
            'tab' => 'referrals::show.tabs.carriers',
            'category' => 'all',
        ],
        [
            'title' => 'Authorizations',
            'href' => 'authorizations',
            'key' => 'referrals_tab_authorizathions',
            'tab' => 'referrals::show.tabs.auth',
            'category' => 'all',
        ],
        [
            'title' => 'Billing',
            'href' => 'billing',
            'key' => 'referrals_tab_billing',
            'tab' => 'referrals::show.tabs.billing',
            'category' => 'all',
        ],
//        [
//            'title' => 'Follow up',
//            'href' => 'followup',
//            'key' => 'referrals_tab_followup',
//            'tab' => 'referrals::show.tabs.followup',
//            'category' => 'all',
//        ],


    ];

    public function mount(Referral $referral)
    {

        $this->referral = $referral;
    }
    public function processChangetab($newActive){

        $this->isActive = $newActive;

    }

    public function render()
    {
        return view('referrals::livewire.show.tabs-panel');
    }
}
