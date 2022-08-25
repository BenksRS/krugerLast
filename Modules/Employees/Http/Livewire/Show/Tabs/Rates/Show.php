<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Rates;

use Livewire\Component;
use Modules\Employees\Entities\EmployeeRate;
use Modules\User\Entities\User;

class Show extends Component
{
    public $user;
    public $rate;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->rate = EmployeeRate::where('user_id', $this->user->id)->first();
    }
    public function render()
    {
        return view('employees::livewire.show.tabs.rates.show');
    }
}
