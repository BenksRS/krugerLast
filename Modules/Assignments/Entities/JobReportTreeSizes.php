<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobReportTreeSizes extends Model
{
    use HasFactory;
    protected $table = 'job_report_tree_sizes';
    protected $fillable = [
        'length',
        'diameter',
        'canopy',
        'job_type_id',
        'assignment_id'
    ];

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\JobReportTreeSizesFactory::new();
    }
}
