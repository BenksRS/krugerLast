<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobReportReports extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_report_id',
        'report_option_id',
        'job_type_id',
        'assignment_id'
    ];

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\JobReportReportsFactory::new();
    }
}
