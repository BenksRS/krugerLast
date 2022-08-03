<?php

namespace Modules\Employees\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeTimesheet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'created_by', 'updated_by', 'approved_by', 'week', 'year', 'start_date', 'end_date', 'due_on', 'status', 'approved_at'];
    
    protected static function newFactory()
    {
        return \Modules\Employees\Database\factories\EmployeeTimesheetFactory::new();
    }
}
