<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentsJobTypesPivot extends Model
{
    use HasFactory;
    protected $table = 'assignments_job_types_pivot';
    protected $fillable = [
        'assignment_id',
        'assignment_job_type_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\AssignmentsJobTypesPivotFactory::new();
    }
}
