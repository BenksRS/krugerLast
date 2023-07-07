<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\User\Entities\User;

class Docs extends Component
{

    public $user;
    public $docs = [];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->docs = config('employees.docs');
    }

    public function render()
    {
        return view('employees::livewire.show.tabs.docs');
    }
}
