<?php

namespace Modules\Profile\Http\Livewire\Show\Tabs;

use Callkruger\Api\Models\Admin\Employee;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Modules\User\Entities\User;
use Modules\Profile\Traits\TimesheetTrait;
use Modules\Employees\Entities\EmployeeTimesheet;
use Modules\Employees\Entities\EmployeeTimesheetDay;
use Auth;

class Timesheet extends Component
{

    use TimesheetTrait;

    public $user;
    public $authUser;

    public $days;
    public $week;
    public $timesheet;

    public $isEdit;


    public $timesheetEvents = [
        'morning' => 'Morning',
        'afternoon' => 'Afternoon',
        //'out' => 'Sleep Out',
        //'oncall' => 'On Call',
        'hurricane' => 'Hurricane',
    ];


    public function mount(User $user)
    {
        $this->user = $user;
        $this->authUser = Auth::user();

        $this->week = $this->getDaysOfWeek();

        $this->mountTimesheet();
        $this->mountDays();
    }

    public function render()
    {
        return view('profile::livewire.show.tabs.timesheet');
    }

    private function mountTimesheet()
    {
        $this->timesheet = EmployeeTimesheet::where('user_id', $this->user->id)
            ->where('week', $this->week['week'])
            ->where('year', $this->week['year'])->first();


        if (in_array($this->timesheet->status, ['new', 'pending'])) {
            $this->isEdit = true;
        } else {
            $this->isEdit = false;
        }
    }

    private function mountDays()
    {
        if (!$this->timesheet) return;
        $timesheet = EmployeeTimesheetDay::where('employee_timesheet_id', $this->timesheet->id)->orderBy('date')->get();

        foreach ($timesheet as $day) {
            $this->days[$day->day_week] = [
                'morning' => $day->morning,
                'afternoon' => $day->afternoon,
                'out' => $day->out,
                'oncall' => $day->oncall,
                'hurricane' => $day->hurricane,
                'off' => $day->off,
            ];
        }
    }


    public function saveDays()
    {
        $timesheetId = $this->timesheet->id;

        foreach ($this->days as $dayWeek => $days) {
            $days['updated_by'] = $this->authUser->id;
            EmployeeTimesheetDay::where('employee_timesheet_id', $timesheetId)->where('day_week', $dayWeek)->update($days);
        }

        $this->timesheet->update([
            'updated_by' => $this->authUser->id,
            'status' => 'pending',
        ]);
    }



    public function disableAll($day)
    {
        foreach ($this->timesheetEvents as $key => $value) {
            $this->days[$day][$key] = 0;
        }
    }
}
