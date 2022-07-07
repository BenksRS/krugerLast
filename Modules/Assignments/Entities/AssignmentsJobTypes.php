<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentsJobTypes extends Model
{
    use HasFactory;
    protected $table = 'assignments_job_types';
    protected $fillable = [
        'name',
        'type',
        'active',
        'view'
    ];
    protected $appends  = [
        'url'
    ];
    public function reports ()
    {
        return $this->belongsToMany(JobReportOptions::class, 'job_report_options_pivot', 'job_type_id', 'report_option_id', 'id')->orderBy('name', 'ASC');
    }
    public function getUrlAttribute ()
    {
        return strtolower(str_replace(" ", "-", $this->name));
    }
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\AssignmentsJobTypesFactory::new();
    }
}
