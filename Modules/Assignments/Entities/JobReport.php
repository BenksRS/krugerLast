<?php

namespace Modules\Assignments\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class JobReport extends Model
{
    use HasFactory;
    protected $table = 'job_report';
    protected $fillable = [
        'assignment_id',
        'assignment_job_type_id',
        'service_date',
        'sandbags',
        'anchoring_support',
        'tarp_alterations',
        'height_accomodation',
        'debris',
        'loads',
        'wood_chipper',
        'crane',
        'bobcat_use',
        'bobcat_type',
        'bobcat_hour',
        'pitch',
        'job_info',
        'plywoods',
        's2x4x8',
        's2x4x12',
        's2x4x16',
        'created_by',
        'updated_by'
    ];
    protected $appends  = [
        'service_date_view'
    ];
//    public function workers ()
//    {
//        return $this->belongsToMany(User::class, 'job_report_workers', 'job_report_id', 'worker_id', 'id');
//    }
//    public function reports ()
//    {
//        return $this->belongsToMany(JobReportOptions::class, 'job_report_reports', 'job_report_id', 'report_option_id', 'id');
//    }
    public function getServiceDateViewAttribute (){

        $return = "-";
        if($this->service_date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->service_date)->format('m/d/Y');
        }
        return $return;
    }
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\JobReportFactory::new();
    }
}
