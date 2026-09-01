<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\JobReport;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Entities\JobReport;
use Modules\Assignments\Entities\JobReportServiceTime;
use Modules\Assignments\Entities\JobReportWorkers;
use Modules\User\Entities\User;
use Auth;
use Modules\User\Entities\Workers;

class CleanUp extends Component
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
    public $many_workers;

    public $jobReport;

    public $serviceTimeList;

    public $user;

    public $job_info;

    public $service_date;
    public $start_date;
    public $end_date;

    public $workersDB;

    public $bobcat_use;
    public $mini_use;
    public $mini_type;
    public $mini_hour;
    public $bobcat_type;
    public $bobcat_hour;
    public $travel_bobcat;
    public $travel_miniskid;

    public $workersSelected = [];

    protected $rulesServicetime = [
        'start_date' =>  'required',
        'end_date' =>  'required',
        'many_workers' => 'required',
    ];
    protected $rulesReport = [
        'mini_use' => 'required',

    ];

    public function mount(Assignment $assignment, AssignmentsJobTypes $job_type)
    {
        $this->assignment = $assignment;
        $this->jobType = $job_type;
        $this->jobType_id = $this->jobType->id;

        $this->jobTypeOptions = $this->jobType->reports;
        $this->workers = Workers::with('user')->where('active','Y')->orderBy('order')->get();
        $this->user = Auth::user();
        $this->jobReport = JobReport::where('assignment_id', $this->assignment->id)->where('assignment_job_type_id', $this->jobType_id)->first();

        if(is_null($this->jobReport)){
            $this->show =false;
            $this->workersSelected = $this->reportSelected = [];
        }else{
            $this->show =true;

            $this->job_info = $this->jobReport->job_info;
            $this->bobcat_use = $this->jobReport->bobcat_use;
            $this->mini_use = $this->jobReport->mini_use;
            $this->bobcat_type = $this->jobReport->bobcat_type;
            $this->mini_type = $this->jobReport->mini_type;
            $this->bobcat_hour = $this->jobReport->bobcat_hour;
            $this->mini_hour = $this->jobReport->mini_hour;
            $this->travel_bobcat = $this->jobReport->travel_bobcat;
            $this->travel_miniskid = $this->jobReport->travel_miniskid;

        }
        $this->getCheckboxInfo();
        $this->show = (is_null($this->jobReport)) ? false : true;

        $this->serviceTimeList = JobReportServiceTime::where('assignment_id', $this->assignment->id)->where('job_type_id', $this->jobType_id)->get();

    }
    public function getCheckboxInfo(){

        $this->workersDB = JobReportWorkers::where('assignment_id',$this->assignment->id)->where('job_type_id', $this->jobType_id)->pluck('worker_id');

        $this->workersSelected = User::whereIn('id', $this->workersDB)->get();

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
    public function processEditreport($jobType_id){
        if($jobType_id == $this->jobType->id){
            $this->show = false;
        }
    }
    public function addServiceTime($formData){

        $this->start_date = $formData['start_date'];
        $this->end_date = $formData['end_date'];
        $this->validate($this->rulesServicetime);

        $errors = $this->getErrorBag();
        $data=[
            'start_date' =>  $this->start_date,
            'end_date' =>  $this->end_date,
            'workers' => $this->many_workers,
            'assignment_id' => $this->assignment->id,
            'job_type_id' => $this->jobType_id,
        ];

        if($data['start_date']){
            $data['start_date'] = Carbon::createFromFormat('Y-m-d  H:i', $data['start_date'])->format('Y-m-d H:i:s');
        }

        if($data['end_date']){
            $data['end_date'] = Carbon::createFromFormat('Y-m-d  H:i', $data['end_date'])->format('Y-m-d H:i:s');
        }

        JobReportServiceTime::create($data);

        $this->start_time = $this->end_time = $this->many_workers = null;
        $this->serviceTimeList = JobReportServiceTime::where('assignment_id', $this->assignment->id)->where('job_type_id', $this->jobType_id)->get();

        $this->emit('select2Update');

    }
    public function processSelect2(){

    }
    public function deleteServicetime($id){
        $deletesServicetime = JobReportServiceTime::find($id);
        $deletesServicetime->delete();
        $this->serviceTimeList = JobReportServiceTime::where('assignment_id', $this->assignment->id)->where('job_type_id', $this->jobType_id)->get();

        $this->emit('select2Update');
    }
    public function saveReport(){
        $this->validate($this->rulesReport);
        $errors = $this->getErrorBag();
        $data = [
            'assignment_id' => $this->assignment->id,
            'assignment_job_type_id' => $this->jobType_id,
            'service_date' =>Carbon::now(),
            'bobcat_use' =>$this->bobcat_use,
            'mini_use' =>$this->mini_use,
            'bobcat_type' =>$this->bobcat_type,
            'mini_type' =>$this->mini_type,
            'bobcat_hour' =>$this->bobcat_hour,
            'mini_hour' =>$this->mini_hour,
            'travel_bobcat' =>$this->travel_bobcat,
            'travel_miniskid' =>$this->travel_miniskid,
            'job_info' =>$this->job_info,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id
        ];

        if(is_null($this->jobReport)){
            // INSERT job Report
            $jobreport = JobReport::create($data);
            $jobreport->save();
        }else{
            $this->jobReport->update($data);

        }

        $this->jobReport = JobReport::where('assignment_id', $this->assignment->id)->where('assignment_job_type_id', $this->jobType_id)->first();
        $this->show = (is_null($this->jobReport)) ? false : true;

        $this->getCheckboxInfo();

    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.job-report.clean-up', [
            'serviceList' => $this->serviceTimeList,
        ]);
    }
}