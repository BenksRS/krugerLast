<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Timesheet;
use Auth;
use Carbon\Carbon;
use Livewire\Component;
use Modules\Employees\Entities\EmployeeTimesheet;
use Modules\Employees\Entities\EmployeeTimesheetDay;
use Modules\User\Entities\User;


class ListAll extends Component
{
    protected $listeners = [
        'backList'
    ];
    public $user;
    public $timesheets;
    public $timesheet_id;
    public $new_week;
    public $new_timesheet=[];
    public $new_timesheet_days=[];

    public $showList=true;
    public $showTimesheet=false;

    public $auth_user;


    public function mount(User $user)
    {
        $this->user = $user;
        $this->auth_user = Auth::user();
        $this->timesheets=EmployeeTimesheet::where('user_id', $this->user->id)->get();

    }
    public function updated($field)
    {
        if ($field == 'new_week')
        {
//            $this->getNewWeek();
        }
    }

    public function createWeek(){
        $this->new_timesheet =[];

        $date = Carbon::parse($this->new_week);
        $week=$date->weekOfYear;
        $year=$date->year;

        $check_week = EmployeeTimesheet::where('user_id', $this->user->id)
            ->where('week', $week)
            ->where('year', $year)
            ->get();

        if(count($check_week) == 0){
            // add new week

            $date->setISODate($year,$week);
            $new_timesheet['week']=$week;
            $new_timesheet['year']=$year;

            $new_timesheet['start_date']=$date->startOfWeek()->format('Y-m-d H:i');
            $new_timesheet['end_date']=$date->endOfWeek()->format('Y-m-d H:i');
            $new_timesheet['due_on']=$date->next('Friday')->format('Y-m-d H:i');
            $new_timesheet['user_id']=$this->user->id;

            $created_timesheet=EmployeeTimesheet::create($new_timesheet);

            // add days
            $date->setISODate($year,$week);
            $new_timesheet_days=[
                [
                    'user_id' => $this->user->id,
                    'employee_timesheet_id' => $created_timesheet->id,
                    'updated_by'=> $this->auth_user->id,
                    'day_week' => 'monday',
                    'date' => $date->startOfWeek()->format('Y-m-d H:i')
                ],
                [
                    'user_id' => $this->user->id,
                    'employee_timesheet_id' => $created_timesheet->id,
                    'updated_by'=> $this->auth_user->id,
                    'day_week' => 'tuesday',
                    'date' => $date->modify("this tuesday")->format('Y-m-d H:i')
                ],
                [
                    'user_id' => $this->user->id,
                    'employee_timesheet_id' => $created_timesheet->id,
                    'updated_by'=> $this->auth_user->id,
                    'day_week' => 'wednesday',
                    'date' => $date->modify("this wednesday")->format('Y-m-d H:i')
                ],
                [
                    'user_id' => $this->user->id,
                    'employee_timesheet_id' => $created_timesheet->id,
                    'updated_by'=> $this->auth_user->id,
                    'day_week' => 'thursday',
                    'date' => $date->modify("this thursday")->format('Y-m-d H:i')
                ],
                [
                    'user_id' => $this->user->id,
                    'employee_timesheet_id' => $created_timesheet->id,
                    'updated_by'=> $this->auth_user->id,
                    'day_week' => 'friday',
                    'date' => $date->modify("this friday")->format('Y-m-d H:i')
                ],
                [
                    'user_id' => $this->user->id,
                    'employee_timesheet_id' => $created_timesheet->id,
                    'updated_by'=> $this->auth_user->id,
                    'day_week' => 'saturday',
                    'date' => $date->modify("this saturday")->format('Y-m-d H:i')
                ],
                [
                    'user_id' => $this->user->id,
                    'employee_timesheet_id' => $created_timesheet->id,
                    'updated_by'=> $this->auth_user->id,
                    'day_week' => 'sunday',
                    'date' => $date->modify("this sunday")->format('Y-m-d H:i')
                ]
            ];

            foreach($new_timesheet_days as $row){

                EmployeeTimesheetDay::create($row)->save();
            }
        }


        $this->timesheets=EmployeeTimesheet::where('user_id', $this->user->id)->get();
        $this->toogleList();

    }


    public function backList(){
        $this->timesheet_id = null;

        $this->showList=true;
        $this->showTimesheet=false;

    }
    public function show($id){
        $this->timesheet_id = $id;

        $this->showList=false;
        $this->showTimesheet=true;


    }
    public function delete($id){
        EmployeeTimesheet::find($id)->delete();
        $this->timesheets=EmployeeTimesheet::where('user_id', $this->user->id)->get();
    }
    public function toogleList(){
        $this->showList =!$this->showList;
    }
    public function render()
    {
        return view('employees::livewire.show.tabs.timesheet.list-all');
    }
}
