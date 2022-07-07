<?php

namespace Modules\Assignments\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobReportServiceTime extends Model
{
    use HasFactory;
    protected $table = 'job_report_service_time';
    protected $fillable = [
        'start_date',
        'end_date',
        'workers',
        'job_type_id',
        'assignment_id'
    ];
    protected $appends  = ['start_date_view', 'end_date_view'];

    public function getStartDateViewAttribute (){

        $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('m/d/Y g:i A');

        return $return;
    }
    public function getEndDateViewAttribute (){

        $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date)->format('m/d/Y g:i A');

        return $return;
    }
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\JobReportServiceTimeFactory::new();
    }
}
