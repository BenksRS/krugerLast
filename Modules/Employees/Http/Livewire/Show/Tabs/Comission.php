<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\User\Entities\User;

class Comission extends Component
{
    public $user;
    public function mount(User $user)
    {

        $this->user = $user;
    }
    public function render()
    {
        return view('employees::livewire.show.tabs.comission');
    }
}
