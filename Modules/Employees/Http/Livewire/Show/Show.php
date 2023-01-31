<?php

namespace Modules\Employees\Http\Livewire\Show;

use Livewire\Component;

class Show extends Component
{
    public $user;
    public function mount(User $user)
    {
        $this->user = $user;
    }
    public function render()
    {
        return view('employees::livewire.show.show');
    }

}
