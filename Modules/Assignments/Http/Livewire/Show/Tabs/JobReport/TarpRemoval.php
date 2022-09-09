<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\JobReport;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Entities\JobReport;
use Modules\Assignments\Entities\JobReportOptions;
use Modules\Assignments\Entities\JobReportReports;
use Modules\Assignments\Entities\JobReportTarpSizes;
use Modules\Assignments\Entities\JobReportWorkers;
use Modules\Assignments\Entities\StockTarps;
use Modules\User\Entities\User;
use Auth;
use Modules\User\Entities\Workers;

class TarpRemoval extends Component
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
    public $tarpStock;
    public $workers;

    public $jobReport;

    public $tarpSizeList;

    public $user;
    public $width;
    public $height;
    public $qty;
    public $pitch;
    public $stock_id;
    public $job_info;
    public $sandbags;
    public $service_date;
    public $reportsDB;
    public $workersDB;
    public $tarp_alterations;
    public $height_accomodation;
    public $tarp_situation;
    public $anchoring_support='Y';

    public $workersSelected = [];
    public $reportSelected = [];

    protected $rulesTarpsize = [
        'width' => 'required|numeric|gt:0',
        'height' => 'required|numeric|gt:0',
        'qty' => 'required|numeric|gt:0',
        'stock_id' => 'required',
    ];
    protected $rulesReport = [
        'sandbags' => 'required',
        'service_date' => 'required',
        'anchoring_support' => 'required',
        'tarp_alterations' => 'required',
        'height_accomodation' => 'required',
        'pitch' => 'required',
        'tarp_situation' => 'required',

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
            $this->sandbags = $this->jobReport->sandbags;
            $this->anchoring_support = $this->jobReport->anchoring_support;
            $this->tarp_alterations = $this->jobReport->tarp_alterations;
            $this->anchoring_support = $this->jobReport->anchoring_support;
            $this->height_accomodation = $this->jobReport->height_accomodation;
            $this->tarp_situation = $this->jobReport->tarp_situation;
            $this->job_info = $this->jobReport->job_info;
            $this->pitch = $this->jobReport->pitch;
            $this->service_date = $this->jobReport->service_date;
//            $this->workersDB = $this->jobReport->workers->pluck('id');
//            $this->reportsDB = $this->jobReport->reports->pluck('id');
//            $this->workersSelected = $this->workersDB->toArray();
//            $this->reportSelected = $this->reportsDB->toArray();

        }
        $this->getCheckboxInfo();
        $this->show = (is_null($this->jobReport)) ? false : true;

        $this->tarpStock = StockTarps::all();
        $this->tarpSizeList = JobReportTarpSizes::where('assignment_id', $this->assignment->id)->where('job_type_id', $this->jobType_id)->get();

    }
    public function getCheckboxInfo(){
        $this->reportsDB = JobReportReports::where('assignment_id',$this->assignment->id)->where('job_type_id', $this->jobType_id)->pluck('report_option_id');
        $this->workersDB = JobReportWorkers::where('assignment_id',$this->assignment->id)->where('job_type_id', $this->jobType_id)->pluck('worker_id');

        $this->reportSelected = JobReportOptions::whereIn('id', $this->reportsDB)->get();
        $this->workersSelected = User::whereIn('id', $this->workersDB)->get();

    }
    public function updated($field)
    {
        if ($field == 'service_date')
        {

        }
    }
    public function processEditreport($jobType_id){
        if($jobType_id == $this->jobType->id){
            $this->show = false;
        }


    }
    public function processSelect2(){

    }
    public function deleteTarpsize($id){

        $deletesTarpsize = JobReportTarpSizes::find($id);
        $deletesTarpsize->delete();
        $this->tarpSizeList = JobReportTarpSizes::where('assignment_id', $this->assignment->id)->where('job_type_id', $this->jobType_id)->get();

        $this->emit('select2Update');
    }
    public function saveReport($formData){
        $this->service_date = $formData['service_date'];

        $this->validate($this->rulesReport);
        $errors = $this->getErrorBag();
        $data = [
            'assignment_id' => $this->assignment->id,
            'assignment_job_type_id' => $this->jobType_id,
            'service_date' => $this->service_date,
            'sandbags' => $this->sandbags,
            'anchoring_support' =>$this->anchoring_support,
            'tarp_alterations' =>$this->tarp_alterations,
            'height_accomodation' =>$this->height_accomodation,
            'tarp_situation' =>$this->tarp_situation,
            'job_info' =>$this->job_info,
            'pitch' =>$this->pitch,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id
        ];

        if(is_null($this->jobReport)){

            // INSERT job Report
            JobReport::create($data)->save();
        }else{
            $this->jobReport->update($data);
        }
        // add reports



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
    public function syncReport($id){

        $checkReport = JobReportReports::where('assignment_id',$this->assignment->id)->where('job_type_id', $this->jobType_id)->where('report_option_id', $id)->get();


        if(count($checkReport) > 0){
            foreach ($checkReport as $row){
                $row->delete();
            }
        }else{
            JobReportReports::create([
                'report_option_id' => $id,
                'job_type_id' => $this->jobType_id,
                'assignment_id' => $this->assignment->id,
            ])->save();
        }

        $this->reportsDB = JobReportReports::where('assignment_id',$this->assignment->id)->where('job_type_id', $this->jobType_id)->pluck('report_option_id');
    }

    public function addTarpSize(){
        $this->validate($this->rulesTarpsize);

        $errors = $this->getErrorBag();

        JobReportTarpSizes::create([
            'width' => $this->width,
            'height' => $this->height,
            'qty' =>$this->qty,
            'stock_id' =>$this->stock_id,
            'assignment_id' =>$this->assignment->id,
            'job_type_id' =>$this->jobType_id,
        ])->save();

        $this->width = $this->height = $this->qty = $this->stock_id = null;
        $this->tarpSizeList = JobReportTarpSizes::where('assignment_id', $this->assignment->id)->where('job_type_id', $this->jobType_id)->get();

        $this->emit('select2Update');
    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.job-report.tarp-removal', [
            'tsList' => $this->tarpSizeList
        ]);
    }
}
