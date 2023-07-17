<?php

namespace Modules\Dashboard\Http\Livewire\List;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Assignments\Entities\AssignmentsPhones;
use Modules\Assignments\Entities\AssignmentsScheduling;
use Modules\Assignments\Repositories\AssignmentRepository;
use Modules\Notes\Entities\Note;

use Auth;
use Modules\User\Entities\Techs;

class Jobstech extends Component
{


    public $searchAssignment;
    public $columns = ['Name','Job Type','Schedule','Status','Referral','Address','Street','City','State', 'Phone', 'Created by', 'Created At', 'Update By','Update At'];
    public $selectedColumns = [];
    public $selectedRows = 100;
    public $user;
    public $techs;

    public $date;
    public $listAll;
    public $dateDisplay;
    public $weekDisplay;

    public function mount()
    {
        $this->selectedColumns = $this->columns;
        $this->techs= Techs::where('active','Y')->orderBy('order')->get();
        $this->user = Auth::user();
//        $preview= Carbon::create(2023, 2, 16, 0, 0, 0);
        $this->date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->format('Y-m-d');

//        $this->date = Carbon::createFromFormat('Y-m-d H:i:s', $preview)->format('Y-m-d');
        $this->dateDisplay = Carbon::createFromFormat('Y-m-d', $this->date)->format('F d, Y');
        $this->weekDisplay = Carbon::createFromFormat('Y-m-d', $this->date)->format('l');
    }
    public function updatingSearchAssignment()
    {
        $this->resetPage();
    }
    public function changeDate ($action)
    {
        $modify = $action == 'prev' ? '-1' : '+1';
        $this->setDate($modify);
    }
    protected function setDate ($modify = NULL)
    {
        $dateTime = new \DateTime($this->date);
        if ( $modify ) {
            $dateTime->modify("$modify day");
        }
        $this->date=$dateTime;

        $this->date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($this->date))->format('Y-m-d');

        $this->dateDisplay = Carbon::createFromFormat('Y-m-d', $this->date)->format('F d, Y');
        $this->weekDisplay = Carbon::createFromFormat('Y-m-d', $this->date)->format('l');



//        dd( $this->date);
    }

    public function export()
    {
        $now=Carbon::now();
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=scheduled_jobs_$now.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $today = $this->date;
        $reviews = AssignmentRepository::TextJobs($today)->get();
        $columns = array('first_name', 'last_name', 'id');

        $callback = function() use ($reviews)
        {
            $file = fopen('php://output', 'w');

            foreach($reviews as $review) {
                if(!$review->tags->contains(10)){

                    $phone=AssignmentsPhones::where('assignment_id', $review->id)->first();

                    if(isset($phone)){
                        $phone_number=$phone->phone;
                    }else{
                        $phone_number='';
                    }

                    $check_carrier=array(582,583);

                    if(isset($review->carrier_id)){
                        if(!in_array($review->carrier_id, $check_carrier)){
                            $carrier=Referral   ::find($review->carrier_id);
                            $carrier_name=$carrier->company_entity;
                        }else{
                            $carrier_name='';
                        }
                    }else{
                        if($review->carrier_info){
                            $carrier_name=$review->carrier_info;
                        }else{
                            $carrier_name='';
                        }

                    }

                    if($review->claim_number){
                        $claim = $review->claim_number;
                    }else{
                        $claim = '';
                    }
                    fputcsv($file, array($review->first_name, $review->last_name, $phone_number, $carrier_name, $review->id, $claim, $review->address->message));


                    $review->tags()->attach(10);

                    Note::create([
                        'text'=> "### TEXT SCHEDULED SENT ### ",
                        'notable_id'=> $review->id,
                        'created_by'=> $this->user->id,
                        'type'=> 'assignment',
                        'notable_type'=>  'Modules\Assignments\Entities\Assignment',
                    ]);
                }//end if tag 10
            }
            fclose($file);



        };



        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {

        $today = $this->date;
        $list = AssignmentRepository::SchedJobs($today)->get();
//        $list=$list->sortBy('scheduling.tech.id')->sortBy('start_date');
//        $list = AssignmentsScheduling::with('assignment')->whereDate('start_date', $today)->get();


        return view('dashboard::livewire.list.jobstech', [
            'list' => $list
        ]);

    }
}
