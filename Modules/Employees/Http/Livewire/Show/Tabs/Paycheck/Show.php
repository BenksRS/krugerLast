<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Paycheck;

use Livewire\Component;
use Modules\Employees\Entities\EmployeePaycheck;
use Modules\User\Entities\User;

class Show extends Component
{
    public $user;
    public $paycheck;

    public function mount(User $user, EmployeePaycheck $paycheck)
    {
        $this->user = $user;
        $this->paycheck = $paycheck;
    }
    public function showMoney($var){
        return number_format($var,2);
    }

    public function render()
    {
        return view('employees::livewire.show.tabs.paycheck.show');
    }
}
