<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\User\Entities\User;

class Rules extends Component
{
    protected $listeners = [
        'toggleShowRules'
    ];

    public $show=true;
    public $user;
    public function mount(User $user)
    {

        $this->user = $user;
    }
    public function toggleShowRules(){
        $this->show =!$this->show;
    }
    public function render()
    {
        return view('employees::livewire.show.tabs.rules');
    }
}
