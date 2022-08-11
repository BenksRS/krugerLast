<?php

namespace Modules\Employees\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Assignments\Repositories\AssignmentRepository;
use Modules\User\Entities\User;


class EmployeeCommissions extends Model
{
    use HasFactory;
    protected $table    = 'employee_commissions';
    protected $fillable = [
        'user_id',
        'assignment_id',
        'job_type',
        'amount',
        'status',
        'rule_id',
        'due_month',
        'due_year',
        'payroll_id'
    ];
    public function rule()
    {
        return $this->belongsTo(EmployeeRules::class, 'rule_id', 'id');
    }
    public function assignment()
    {
        return $this->belongsTo(AssignmentFinanceRepository::class, 'assignment_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    protected static function newFactory()
    {
        return \Modules\Employees\Database\factories\EmployeeCommissionsFactory::new();
    }

}
