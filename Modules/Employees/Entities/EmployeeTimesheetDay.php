<?php

namespace Modules\Employees\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeTimesheetDay extends Model {

    use HasFactory;

    protected $fillable = ['user_id', 'employee_timesheet_id', 'updated_by', 'date', 'day_week', 'off', 'out', 'oncall', 'morning', 'afternoon', 'hurricane'];
    protected $appends = [
        'date_view',
        'date_timesheet'
        ];

    public function timesheet()
    {
        return $this->belongsTo(EmployeeTimesheet::class, 'employee_timesheet_id', 'id');
    }
    public function getDateViewAttribute(){

        $return = "-";
        if($this->date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->date)->format('m/d/Y');
        }
        return $return;
    }
    public function getDateTimesheetAttribute(){

        $return = "-";
        if($this->date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->date)->format('l M d');
        }
        return $return;
    }
    protected static function newFactory ()
    {
        return \Modules\Employees\Database\factories\EmployeeTimesheetDayFactory::new();
    }

}
