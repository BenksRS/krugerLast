<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Employees\Entities\EmployeeCommissions;
use Modules\Employees\Http\Controllers\EmployeesController;
use Modules\Gdrive\Entities\QueeFiles;

class Comissions extends Component
{
    protected $listeners = [
        'update_commission_run',
        'delete_commission'
    ];
    public $assignment;

    public $listCommissions;

    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->listCommissions = EmployeeCommissions::with('rule')->where('assignment_id', $this->assignment->id)->get();

    }

    public function update_commission_run(){
        dd('run');
    }
    public function delete_commission($var){


        $deletesComission = EmployeeCommissions::find($var);
        $deletesComission->delete();

        if(in_array($this->assignment->status_id,[5,6,10,24,9])){
            $employees = new EmployeesController();

            $employees->check_comission($this->assignment->id);

            $this->listCommissions = EmployeeCommissions::with('rule')->where('assignment_id', $this->assignment->id)->get();
        }


    }
    public function update_commission(){

        if(in_array($this->assignment->status_id,[5,6,10,24,9])){
            $employees = new EmployeesController();

            $employees->check_comission($this->assignment->id);

            $this->listCommissions = EmployeeCommissions::with('rule')->where('assignment_id', $this->assignment->id)->get();
        }


    }
    public function showMoney($var){
        return number_format($var,2);
    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.comissions');
    }
}
