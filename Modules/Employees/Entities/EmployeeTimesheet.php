<?php

namespace Modules\Employees\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Assignments\Entities\Signdata;
use Modules\User\Entities\User;

class EmployeeTimesheet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'created_by', 'updated_by', 'approved_by', 'week', 'year', 'start_date', 'end_date', 'due_on', 'status', 'approved_at'];
    protected $appends = [
        'due_on_view',
        'approved_view',
        'start_md',
        'end_md',
        'finance'

    ];
    public function rates()
    {
        return $this->belongsTo(EmployeeRate::class, 'user_id', 'user_id');
    }
    public function days()
    {
        return $this->hasMany(EmployeeTimesheetDay::class, 'employee_timesheet_id', 'id');
    }

    public function user_created()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function user_updated()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function user_approved()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
    public function getFinanceAttribute(){

        switch ($this->rates->type){
            case 'D':
                    // preset days
                $weekDays=$this->days->whereIn('day_week',['monday','tuesday','wednesday','thursday','friday']);
                $weekendDays=$this->days->whereIn('day_week',['saturday','sunday']);

                //regular
                $week_days=(($weekDays->sum('morning') +  $weekDays->sum('afternoon'))/ 2);
                $total_week_days=(($week_days) * ($this->rates->regular_day));

                $regular=(object)[
                    'days' =>$week_days,
                    'total' =>$total_week_days,
                ];

                //weekend
                $weekend_days=(int)ceil(($weekendDays->sum('morning') +  $weekendDays->sum('afternoon'))/ 2);
                $total_weekend_days=(($weekend_days) * ($this->rates->weekend_day));

                $weekend=(object)[
                    'days' =>$weekend_days,
                    'total' =>$total_weekend_days,
                ];

                //sleep out
                $sleep_out_days=$this->days->sum('out');
                $total_sleep_out_days=(($sleep_out_days) * ($this->rates->sleep_out));
                $out=(object)[
                    'days' =>$sleep_out_days,
                    'total' =>$total_sleep_out_days,
                ];

                //on call
                $oncall_days=$this->days->sum('oncall');
                $total_oncall_days=(($oncall_days) * ($this->rates->oncall));

                $oncall=(object)[
                    'days' =>$oncall_days,
                    'total' =>$total_oncall_days
                ];
                //hurricane
                $hurricane_days=$this->days->sum('hurricane');
                $total_hurricane_days=(($hurricane_days) * ($this->rates->hurricane));

                $hurricane=(object)[
                    'days' =>$hurricane_days,
                    'total' =>$total_hurricane_days
                ];

                //total
                $total= ($regular->total + $weekend->total + $out->total+ $oncall->total + $hurricane->total);
                $result=(object)[
                    'regular'=>$regular,
                    'weekend'=>$weekend,
                    'out'=>$out,
                    'oncall'=>$oncall,
                    'hurricane'=>$hurricane,
                    'total' =>$total
                ];

                break;
            default:
                $result=[];
                break;
        }

        return $result;
    }
    public function getApprovedViewAttribute(){

        $return = "-";
        if($this->approved_at){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->approved_at)->format('m/d/Y');
        }
        return $return;
    }
    public function getDueOnViewAttribute(){

        $return = "-";
        if($this->due_on){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->due_on)->format('m/d/Y');
        }
        return $return;
    }
    public function getStartMdAttribute(){

        $return = "-";
        if($this->start_date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('m/d');
        }
        return $return;
    }
    public function getEndMdAttribute (){

        $return = "-";
        if($this->end_date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date)->format('m/d');
        }
        return $return;
    }
    protected static function newFactory()
    {
        return \Modules\Employees\Database\factories\EmployeeTimesheetFactory::new();
    }
}
