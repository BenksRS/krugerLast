<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\User\Entities\User;

class Timesheet extends Component
{

    public $showList=true;
    public $user;

    public $timesheet;
    public $timesheetDays;

    public function mount(User $user)
    {

        $this->user = $user;
    }
    public function toogleShow(){
        $this->showList = !$this->showList;
    }
    public function showTimesheet($id){
        $this->toogleShow();
        $this->thimesheet();
    }
    public function render()
    {
        return view('employees::livewire.show.tabs.timesheet');
    }
}
