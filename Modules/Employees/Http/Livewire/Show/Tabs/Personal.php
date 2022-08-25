<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs;

use Livewire\Component;

class Personal extends Component
{

    public $action;

    public function mount(){
        $this->action =\session()->get('action');

    }
    public function render()
    {
        return view('employees::livewire.show.tabs.personal');
    }
}
