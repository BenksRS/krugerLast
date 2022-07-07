<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobReportWorkers extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_report_id',
        'worker_id',
        'job_type_id',
        'assignment_id'
    ];


    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\JobReportWorkersFactory::new();
    }
}
