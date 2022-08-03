<?php

namespace Modules\Employees\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeTimesheetDay extends Model {

    use HasFactory;

    protected $fillable = ['user_id', 'employee_timesheet_id', 'updated_by', 'date', 'day_week', 'off', 'out', 'oncall', 'morning', 'afternoon', 'hurricane'];

    protected static function newFactory ()
    {
        return \Modules\Employees\Database\factories\EmployeeTimesheetDayFactory::new();
    }

}
