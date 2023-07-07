<?php

namespace Modules\Profile\Http\Livewire\Show;

use Livewire\Component;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Route;

class Tabs extends Component
{

    protected $view = 'employees::livewire.show.tabs';

    protected $listeners = [
        'changeTab'       => 'processChangetab',
        'refreshTabPanel' => '$refresh',
    ];

    public    $url;

    public    $user;

    public    $isActive  = 'timesheet';

    public    $navs      = [
        [
            'title'    => 'Time Sheet',
            'href'     => 'timesheet',
            'key'      => 'profile_tab_timesheet',
            'tab'      => 'profile::show.tabs.timesheet',
            'category' => 'profile',
        ],
        [
            'title'    => 'Receipts',
            'href'     => 'receipts',
            'key'      => 'profile_tab_receipts',
            'tab'      => 'employees::show.tabs.receipts',
            'category' => 'profile',
        ],

    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->url  = Route::getCurrentRoute()->uri();
    }

    public function processChangetab($newActive)
    {

        $this->isActive = $newActive;
    }

    public function render()
    {
        return view($this->view);
    }
}
