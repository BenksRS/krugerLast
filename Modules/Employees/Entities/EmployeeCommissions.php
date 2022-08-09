<?php

namespace Modules\Employees\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    protected static function newFactory()
    {
        return \Modules\Employees\Database\factories\EmployeeCommissionsFactory::new();
    }
}
