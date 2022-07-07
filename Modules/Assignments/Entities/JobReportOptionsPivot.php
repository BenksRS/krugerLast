<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobReportOptionsPivot extends Model
{
    use HasFactory;
    protected $table = 'job_report_options_pivot';
    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\JobReportOptionsPivotFactory::new();
    }
}
