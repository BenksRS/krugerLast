<?php

namespace Modules\Employees\Http\Livewire\Show;

use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Modules\User\Entities\User;

class Tabs extends Component
{

    protected $listeners = [
        'changeTab'       => 'processChangetab',
        'refreshTabPanel' => '$refresh',

    ];

    public    $url;

    public    $user;

    public    $isActive  = 'commission';

    public    $navs      = [
        [
            'title'    => 'Daily Rates',
            'href'     => 'daily-rates',
            'key'      => 'employees_tab_daily',
            'tab'      => 'employees::show.tabs.rates',
            'category' => 'all',
        ],
        [
            'title'    => 'Commission',
            'href'     => 'commission',
            'key'      => 'employees_tab_comission',
            'tab'      => 'employees::show.tabs.comission',
            'category' => 'profile',
        ],
        [
            'title'    => 'Rules',
            'href'     => 'rules',
            'key'      => 'employees_tab_rules',
            'tab'      => 'employees::show.tabs.rules',
            'category' => 'profile',
        ],
        [
            'title'    => 'Time Sheet',
            'href'     => 'timesheet',
            'key'      => 'employees_tab_timesheet',
            'tab'      => 'employees::show.tabs.timesheet',
            'category' => 'profile',
        ],
        [
            'title'    => 'Pay Check',
            'href'     => 'paycheck',
            'key'      => 'employees_tab_paycheck',
            'tab'      => 'employees::show.tabs.paycheck',
            'category' => 'profile',
        ],
        [
            'title'    => 'Receipts',
            'href'     => 'receipts',
            'key'      => 'employees_tab_receipts',
            'tab'      => 'employees::show.tabs.receipts',
            'category' => 'profile',
        ],
        [
            'title'    => 'Docs',
            'href'     => 'docs',
            'key'      => 'employees_tab_docs',
            'tab'      => 'employees::show.tabs.docs',
            'category' => 'profile',
        ],
        [
            'title'    => 'Account',
            'href'     => 'account',
            'key'      => 'employees_tab_account',
            'tab'      => 'employees::show.tabs.account',
            'category' => 'profile',
        ],

    ];
    public    $navs_docs      = [
        [
            'title'    => 'Time Sheet',
            'href'     => 'timesheet',
            'key'      => 'employees_tab_timesheet',
            'tab'      => 'employees::show.tabs.timesheet',
            'category' => 'profile',
        ],
        [
            'title'    => 'Docs',
            'href'     => 'docs',
            'key'      => 'employees_tab_docs',
            'tab'      => 'employees::show.tabs.docs',
            'category' => 'profile',
        ],

    ];

    public function mount(User $user)
    {

        $this->user = $user;


        $rota  = Route::getFacadeRoot()->current()->uri();
        $rota  =explode('/',$rota);
        $this->url = $rota[0];


        switch ($this->url){
            case 'profile':
                $this->isActive = 'commission';
                break;
            case 'employees_docs':
                $this->navs = $this->navs_docs;
                $this->isActive = 'docs';
                break;
            default:
                break;
        }
        if ($this->url == 'employees_docs') {

        }
    }

    public function processChangetab($newActive)
    {

        $this->isActive = $newActive;
    }

    public function render()
    {
        return view('employees::livewire.show.tabs');
    }
}
