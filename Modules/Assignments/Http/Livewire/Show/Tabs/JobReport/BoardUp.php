<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\JobReport;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Entities\JobReport;
use Modules\Assignments\Entities\JobReportOptions;
use Modules\Assignments\Entities\JobReportReports;
use Modules\Assignments\Entities\JobReportWorkers;
use Modules\User\Entities\User;
use Auth;
use Modules\User\Entities\Workers;

class BoardUp extends Component
{

    protected $listeners = [
        'select2Update' => 'processSelect2',
        'editReport' => 'processEditreport',
    ];
    public $show = false;

    public $assignment;
    public $jobType_id;
    public $jobType;
    public $jobTypeOptions;
    public $workers;
    public $jobReport;

    public $user;
    public $job_info;
    public $service_date;
    public $plywoods=0;
    public $s2x4x8=0;
    public $s2x4x12=0;
    public $s2x4x16=0;
    public $workersDB;
    public $workersSelected = [];

    protected $rulesReport = [
        'plywoods' => 'required',
        's2x4x8' => 'required',
        's2x4x12' => 'required',
        's2x4x16' => 'required',
    ];

    public function mount(Assignment $assignment, AssignmentsJobTypes $job_type)
    {
        $this->assignment = $assignment;
        $this->jobType = $job_type;
        $this->jobType_id = $this->jobType->id;

        $this->jobTypeOptions = $this->jobType->reports;
        $this->workers = Workers::with('user')->where('active','Y')->get();
        $this->user = Auth::user();
        $this->jobReport = JobReport::where('assignment_id', $this->assignment->id)->where('assignment_job_type_id', $this->jobType_id)->first();

        if(is_null($this->jobReport)){
            $this->show =false;
            $this->workersSelected = $this->reportSelected = [];
        }else{
            $this->show =true;
            $this->service_date = $this->jobReport->service_date;
            $this->plywoods = $this->jobReport->plywoods;
            $this->s2x4x8 = $this->jobReport->s2x4x8;
            $this->s2x4x12 = $this->jobReport->s2x4x12;
            $this->s2x4x16 = $this->jobReport->s2x4x16;

        }

        $this->getCheckboxInfo();

        $this->show = (is_null($this->jobReport)) ? false : true;
    }
    public function updated($field)
    {
        if ($field == 'service_date')
        {

        }
    }
    public function getCheckboxInfo(){

        $this->workersDB = JobReportWorkers::where('assignment_id',$this->assignment->id)->where('job_type_id', $this->jobType_id)->pluck('worker_id');

        $this->workersSelected = User::whereIn('id', $this->workersDB)->get();

    }
    public function processEditreport($jobType_id){
        if($jobType_id == $this->jobType->id){
            $this->show = false;
        }


    }

    public function saveReport($formData){
        $this->service_date = $formData['service_date'];
        $this->validate($this->rulesReport);
        $errors = $this->getErrorBag();
        $data = [
            'assignment_id' => $this->assignment->id,
            'assignment_job_type_id' => $this->jobType_id,
            'service_date' => $this->service_date,
            'plywoods' => $this->plywoods,
            's2x4x8' =>$this->s2x4x8,
            's2x4x12' =>$this->s2x4x12,
            's2x4x16' =>$this->s2x4x16,
            'job_info' =>$this->job_info,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id
        ];


        if(is_null($this->jobReport)){
            // INSERT job Report
            JobReport::create($data)->save();
        }else{
            $this->jobReport->update($data);
        }


        $this->jobReport = JobReport::where('assignment_id', $this->assignment->id)->where('assignment_job_type_id', $this->jobType_id)->first();
        $this->show = (is_null($this->jobReport)) ? false : true;

        $this->getCheckboxInfo();

    }
    public function syncWorkers($id){

        $checkWorker = JobReportWorkers::where('assignment_id',$this->assignment->id)->where('job_type_id', $this->jobType_id)->where('worker_id', $id)->get();

        if(count($checkWorker) > 0){
            foreach ($checkWorker as $row){
                $row->delete();
            }
        }else{
            JobReportWorkers::create([
                'worker_id' => $id,
                'job_type_id' => $this->jobType_id,
                'assignment_id' => $this->assignment->id,
            ])->save();
        }

        $this->workersDB = JobReportWorkers::where('assignment_id',$this->assignment->id)->where('job_type_id', $this->jobType_id)->pluck('worker_id');
    }
    public function processSelect2(){

    }






    public function render()
    {
        return view('assignments::livewire.show.tabs.job-report.board-up');
    }
}
