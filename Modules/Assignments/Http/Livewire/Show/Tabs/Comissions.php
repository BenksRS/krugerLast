<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Employees\Entities\EmployeeCommissions;
use Modules\Employees\Http\Controllers\EmployeesController;

class Comissions extends Component
{
    public $assignment;

    public $listCommissions;

    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->listCommissions = EmployeeCommissions::with('rule')->where('assignment_id', $this->assignment->id)->get();

    }

    public function update_commission(){
        $employees = new EmployeesController();

        $employees->check_comission($this->assignment->id);

        $this->listCommissions = EmployeeCommissions::with('rule')->where('assignment_id', $this->assignment->id)->get();
    }
    public function showMoney($var){
        return number_format($var,2);
    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.comissions');
    }
}
