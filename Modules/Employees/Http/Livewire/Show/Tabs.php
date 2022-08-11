<?php

namespace Modules\Employees\Http\Livewire\Show;

use Livewire\Component;
use Modules\User\Entities\User;

class Tabs extends Component
{

    protected $listeners = [
        'changeTab' => 'processChangetab',
        'refreshTabPanel' => '$refresh'

    ];

    public $user;
    public $isActive = 'commission';
    public $navs = [
        [
            'title' => 'Personal Details',
            'href' => 'personal-details',
            'key' => 'employees_tab_personal',
            'tab' => 'employees::show.tabs.personal',
            'category' => 'all',
        ],
        [
            'title' => 'Daily Rates',
            'href' => 'daily-rates',
            'key' => 'employees_tab_daily',
            'tab' => 'employees::show.tabs.rates',
            'category' => 'all',
        ],
        [
            'title' => 'Commission',
            'href' => 'commission',
            'key' => 'employees_tab_comission',
            'tab' => 'employees::show.tabs.comission',
            'category' => 'all',
        ],
        [
            'title' => 'Rules',
            'href' => 'rules',
            'key' => 'employees_tab_rules',
            'tab' => 'employees::show.tabs.rules',
            'category' => 'all',
        ],
        [
            'title' => 'Time Sheet',
            'href' => 'timesheet',
            'key' => 'employees_tab_timesheet',
            'tab' => 'employees::show.tabs.timesheet',
            'category' => 'all',
        ],
        [
            'title' => 'Pay Check',
            'href' => 'paycheck',
            'key' => 'employees_tab_paycheck',
            'tab' => 'employees::show.tabs.paycheck',
            'category' => 'all',
        ],
        [
            'title' => 'Receipts',
            'href' => 'receipts',
            'key' => 'employees_tab_receipts',
            'tab' => 'employees::show.tabs.receipts',
            'category' => 'all',
        ],

    ];

    public function mount(User $user)
    {

        $this->user = $user;
    }
    public function processChangetab($newActive){

        $this->isActive = $newActive;

    }
    public function render()
    {
        return view('employees::livewire.show.tabs');
    }
}
