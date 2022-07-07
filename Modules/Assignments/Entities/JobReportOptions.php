<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobReportOptions extends Model
{
    use HasFactory;
    protected $table = 'job_report_options';
    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\JobReportOptionsFactory::new();
    }
}
