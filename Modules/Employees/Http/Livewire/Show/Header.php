<?php

namespace Modules\Employees\Http\Livewire\Show;

use Livewire\Component;
use Modules\User\Entities\User;

class Header extends Component
{
    public $show = false;
    public $user;
    public $active;
    public $name;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->active = $user->active;

    }

    public function edit(){

        $this->show = false;
    }
    public function render()
    {
        return view('employees::livewire.show.header');
    }
}
