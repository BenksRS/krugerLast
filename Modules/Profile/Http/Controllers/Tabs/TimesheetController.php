<?php

namespace Modules\Profile\Http\Controllers\Tabs;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Profile\Traits\TimesheetTrait;
use Illuminate\Contracts\Support\Renderable;
use Modules\Employees\Entities\EmployeeRate;
use Modules\Employees\Entities\EmployeeTimesheet;

class TimesheetController extends Controller
{

    use TimesheetTrait;

    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
    }

    public function show()
    {
    }

    public function build(Request $request)
    {
        $daysOfWeek = $this->getDaysOfWeek(0);

        $employeesRates = EmployeeRate::where('type', 'D')->get();


        foreach ($employeesRates as $employeeRate) {


            $checkWeek = EmployeeTimesheet::where('user_id', $employeeRate->user_id)
                ->where('week', $daysOfWeek['week'])
                ->where('year', $daysOfWeek['year'])->get();

            if (count($checkWeek) == 0) {
                $newTimesheet = [
                    'week' => $daysOfWeek['week'],
                    'year' => $daysOfWeek['year'],
                    'start_date' => $daysOfWeek['date']['start'],
                    'end_date' => $daysOfWeek['date']['end'],
                    'due_on' => $daysOfWeek['date']['due_on'],
                    'user_id' => $employeeRate->user_id,
                ];

                $newDays = [];

                foreach ($daysOfWeek['days'] as $day) {
                    $newDays[] = [
                        'day_week' => $day['day_week'],
                        'date' => $day['date'],
                        'user_id' => $employeeRate->user_id,
                        'updated_by' => $employeeRate->user_id,
                    ];
                }

                $createdTimesheet = EmployeeTimesheet::create($newTimesheet);
                $createdTimesheet->days()->createMany($newDays);
            }
        }

        dump('teste');
    }
}
