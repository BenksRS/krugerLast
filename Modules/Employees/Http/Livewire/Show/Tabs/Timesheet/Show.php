<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Timesheet;
use Auth;
use Carbon\Carbon;
use Livewire\Component;
use Modules\Employees\Entities\EmployeeTimesheet;
use Modules\Employees\Entities\EmployeeTimesheetDay;
use Modules\User\Entities\User;

class Show extends Component
{
    public $user;
    public $auth_user;
    public $timesheet;
    public $timesheetDays;

    public $timesheetEdit=false;

    public $monday=[];
    public $tuesday=[];
    public $wednesday=[];
    public $thursday=[];
    public $friday=[];
    public $saturday=[];
    public $sunday=[];



    public function mount(User $user, EmployeeTimesheet $timesheet)
    {

        $this->user = $user;
        $this->auth_user = Auth::user();
        $this->timesheet = $timesheet;
       $this->mountWeek();
    }

    public function toogleEdit(){
        $this->timesheetEdit=!$this->timesheetEdit;

        // change status to pending
        $this->timesheet->update([
            'status'=>'pending',
            'updated_by'=>$this->auth_user->id
        ]);
    }
    public function mountWeek()
    {
        $this->timesheetDays = EmployeeTimesheetDay::where('employee_timesheet_id',  $this->timesheet->id)->orderBy('date')->get();

        foreach ($this->timesheetDays as $day){
            $this->mountArrayDay($day->day_week, $day);
        }


    }
    public function mountArrayDay($day_week, $day){
        $this->{$day_week}=[
            'morning'=> $day->morning,
            'afternoon'=> $day->afternoon,
            'out'=>$day->out,
            'oncall'=> $day->oncall,
            'hurricane'=> $day->hurricane,
            'off'=> $day->off,
        ];
    }

    public function approve(){
        // change status to pending
        $this->timesheet->update([
            'status'=>'approved',
            'approved_by'=>$this->auth_user->id,
            'approved_at'=>Carbon::now()

        ]);
        $this->timesheet=EmployeeTimesheet::find($this->timesheet->id);
    }
    public function saveDays()
    {
        $this->timesheetDays = EmployeeTimesheetDay::where('employee_timesheet_id',  $this->timesheet->id)->orderBy('date')->get();

        foreach ($this->timesheetDays as $day){
            $this->{$day->day_week}['updated_by']=$this->auth_user->id;
            $day->update($this->{$day->day_week});
        }

        // change status to pending
        $this->timesheet->update([
            'status'=>'pending',
            'updated_by'=>$this->auth_user->id
        ]);
        $this->timesheet=EmployeeTimesheet::find($this->timesheet->id);

        // reload infos
        $this->mountWeek();
        $this->timesheetEdit=false;
    }

    public function render()
    {
        return view('employees::livewire.show.tabs.timesheet.show');
    }
}
