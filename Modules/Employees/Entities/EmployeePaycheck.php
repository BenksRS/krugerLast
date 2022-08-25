<?php

namespace Modules\Employees\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class EmployeePaycheck extends Model
{
    use HasFactory;
    protected $table    = 'employee_paychecks';
    protected $fillable = [
        'user_id',
        'employee_timesheet_id',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $appends = [
        'finance'
    ];

    public function timesheet()
    {
        return $this->belongsTo(EmployeeTimesheet::class, 'employee_timesheet_id', 'id');
    }
    public function user_created()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function user_updated()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function receipts()
    {
        return $this->hasMany(EmployeeReceipts::class, 'paycheck_id', 'id');
    }

    public function commissions()
    {
        return $this->hasMany(EmployeeCommissions::class, 'payroll_id', 'id');
    }

    public function getFinanceAttribute(){

        switch ($this->timesheet->rates->type){
            case 'D':
                // preset days


                $total=$this->timesheet->finance->total+$this->receipts->sum('amount')+$this->commissions->sum('amount');

                $result=(object)[
                    'week'=>$this->timesheet->finance->total,
                    'receipts'=> $this->receipts->sum('amount'),
                    'commission'=>$this->commissions->sum('amount'),
                    'total'=>$total,
                ];

                break;
            default:
                $result=[];
                break;

        }

        return $result;
    }

    
    protected static function newFactory()
    {
        return \Modules\Employees\Database\factories\EmployeePaycheckFactory::new();
    }
}
