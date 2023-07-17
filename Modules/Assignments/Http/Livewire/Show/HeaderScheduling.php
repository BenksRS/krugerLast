<?php

namespace Modules\Assignments\Http\Livewire\Show;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Addons\Entities\Assignment\AssignmentStatus;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Entities\AssignmentsScheduling;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Modules\User\Entities\Techs;
use Auth;
use function Ramsey\Uuid\v1;

class HeaderScheduling extends Component
{
    protected $listeners = [
        'showButtons' => 'toggleButtons',
        'showDuplicate' => 'toggleDuplicate',
        'updateNotes',
    ];

    public $showButtons= true;
    public $showDuplicate=true;

    public $assignment;
    public $showChangeTech = false;
    public $showSched = false;
    public $showChangeSched = false;

    public $showFormDate = false;
    public $typeForm;


    public $techs;
    public $techSelected;

    public $user;

    public $jbSelected;
    public $jbSelectedSingle;
    public $jobTypes;
    public $jtDuplicate;


    public $schedule_start;


    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->techs =Techs::all();
        $this->user = Auth::user();

        $this->jbSelected = $this->assignment->job_types;
        $this->jbSelectedSingle = $this->assignment->job_types()->where('type', 'S')->get();

        $this->jobTypes = AssignmentsJobTypes::where('active', 'y')->get();

        $this->checkButons();

    }


    public function updateNotes(){
        $this->assignment = Assignment::find($this->assignment->id);
        $this->showChangeTech = $this->showChangeSched= $this->showSched = false ;
        $this->checkButons();
    }
    public function updateJD($id){

        if(in_array($id, $this->jtDuplicate)){
            $this->jtDuplicate=array_diff($this->jtDuplicate, $id);
        }else{
            $this->jtDuplicate=array_unshift($this->jtDuplicate, $id);
        }
    }
    public function toggleDuplicate(){
        $this->showDuplicate = !$this->showDuplicate;

    }
    public function toggleButtons($info){
        $this->showButtons = !$this->showButtons;
        $this->showDuplicate =true;
        $this->typeForm =  $info;
        if($info == 'full'){
            $this->showFormDate = true;

        }else{
            $this->showFormDate = false;
        }
    }

    public function duplicate(){

        $duplicate = $this->assignment;
        $old_id = $duplicate->id;
        $duplicate->load('phones', 'notes');

        //remove dados fixos
        unset($duplicate->id);
        unset($duplicate->follow_up);
        unset($duplicate->event_id);
        unset($duplicate->inside_info);
        unset($duplicate->created_at);
        unset($duplicate->updated_at);

        $duplicate->date_assignment=Carbon::now();
        $duplicate->created_by=$this->user->id;
        $duplicate->updated_by=$this->user->id;
        $duplicate->status_id=1;
        $duplicate->status_collection_id=3;

        $clone = $duplicate->replicate();
        $clone->save();

        // add job type
        $clone->job_types()->attach($this->jtDuplicate);

        // phones
        foreach ($duplicate->phones as $phone){
//            dd($phone);
            $phone->assignment_id = $clone->id;
            unset($phone->id);
            $clone_phone =  $phone->replicate();
            $clone_phone->save();
        }
        // notes
        foreach ($duplicate->notes as $note){

            if($note->type == 'assignment'){
                $note->notable_id = $clone->id;
                unset($note->id);
                $clone_note =  $note->replicate();
                $clone_note->save();
            }
        }

        // add cloning note
            $text = "Job duplicated from #$old_id";
        $clone->notes()->create([
            'text'=> $text,
            'notable_id'=> $clone->id,
            'created_by'=> $this->user->id,
            'type'=> 'assignment',
            'notable_type'=>  Assignment::class,
        ]);

            return $this->redirect("/assignments/show/$clone->id");



    }
    public function schedule(){
        $Schedule=AssignmentsScheduling::where('assignment_id', $this->assignment->id)->first();

        if($Schedule){
            //update
            $this->ScheduleUpdate();
        }else{
            // insert
            $this->scheduleInsert();
        }
        $this->updateNotes();
    }

    public function alacrityVisitPlanned($date){

        if($this->assignment->referral->id == 24) {
            // alacrity time zone
            switch ($this->assignment->state) {
                case 'LA':
                    $ContactDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->subHours(1)->format('Y-m-d H:i:s');
                    break;
                default:
                    $ContactDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
                    break;
            }

            alacrity_service()->post('UpdateDates', ['AssignmentId' => $this->assignment->allacrity_id],
                ["AssignmentDates" => [
                    'ScheduledVisitDate' => $ContactDate
                ]]);

            $this->emit('contentCC');
        }

    }
    public function ScheduleUpdate(){
        $Schedule=AssignmentsScheduling::where('assignment_id', $this->assignment->id)->first();

        $tech_info = Techs::find($this->techSelected);
        $tech_name = $tech_info->user->name;
        $AssignmentsScheduling=[
            'assignment_id' => $this->assignment->id,
            'tech_id' => $this->techSelected,
            'updated_by' => $this->user->id,
        ];
        $description = "Scheduled: change tech to $tech_name";
        if($this->schedule_start){
            $data_start = Carbon::createFromFormat('Y-m-d  H:i', $this->schedule_start)->format('Y-m-d H:i:s');
            $data_start_show=Carbon::createFromFormat('Y-m-d  H:i', $this->schedule_start)->format('m/d/Y g:i A');
            $data_end = strtotime($data_start)+60*60;
            $data_end = date('Y-m-d H:i:s', $data_end);
            $data_end_show=Carbon::parse($data_start_show)->addHour()->format('m/d/Y g:i A');
//            $data_end_show=Carbon::createFromFormat('Y-m-d  H:i', $data_end)->format('m/d/Y g:i A');
            $AssignmentsScheduling['start_date']=$data_start;
            $AssignmentsScheduling['end_date']=$data_end;

            $description = "Scheduled: $data_start_show to $data_end_show - Tech : $tech_name";

            // update schedulle visit
            $this->alacrityVisitPlanned($data_start);
        }

        $Schedule->update($AssignmentsScheduling);




        // $AssignmentStatus
        $AssignmentStatus=[
            'assignment_id'  => $this->assignment->id,
            'assignment_status_id'  => 2,
            'created_by'  => $this->user->id,
            'description'  => $description,
        ];
        AssignmentsStatusPivot::create($AssignmentStatus);

        $update_status=[
            'status_id'  => 2,
            'updated_by'  => $this->user->id,
        ];
        $this->assignment->update($update_status);




        $this->techSelected = $this->schedule_start = null;


        $this->assignment = Assignment::find($this->assignment->id);
        $this->emit('updateScheduling');
        $this->toggleButtons('back');

        integration('assignments')->set($this->assignment->id);

    }
    public function scheduleInsert(){

        if($this->schedule_start){
            $data_start = Carbon::createFromFormat('Y-m-d  H:i', $this->schedule_start)->format('Y-m-d H:i:s');
            $data_start_show = Carbon::createFromFormat('Y-m-d  H:i', $this->schedule_start)->format('m/d/Y g:i A');
            $data_end = strtotime($data_start)+60*60;
            $data_end_show=Carbon::parse($data_start_show)->addHour()->format('m/d/Y g:i A');
//            $data_end_show=Carbon::createFromFormat('Y-m-d  H:i', $data_end)->format('m/d/Y g:i A');
            $data_end = date('Y-m-d H:i:s', $data_end);

            // update schedulle visit
            $this->alacrityVisitPlanned($data_start);
        }

        $tech_info = Techs::find($this->techSelected);
        $tech_name = $tech_info->user->name;

        $AssignmentsScheduling=[
            'assignment_id' => $this->assignment->id,
            'tech_id' => $this->techSelected,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
            'start_date' => $data_start,
            'end_date' => $data_end,
        ];
        AssignmentsScheduling::create($AssignmentsScheduling);

        $description = "Scheduled: $data_start_show to $data_end_show - Tech : $tech_name";

        $AssignmentStatus=[
          'assignment_id'  => $this->assignment->id,
          'assignment_status_id'  => 2,
          'created_by'  => $this->user->id,
            'description'  => $description,
        ];
        AssignmentsStatusPivot::create($AssignmentStatus);

        $update_status=[
            'status_id'  => 2,
            'updated_by'  => $this->user->id,
        ];
        $this->assignment->update($update_status);

        $this->assignment = Assignment::find($this->assignment->id);

        $this->emit('updateScheduling');
        $this->toggleButtons('back');


        integration('assignments')->set($this->assignment->id);
    }
    public function checkButons(){
        switch ($this->assignment->status->class){

            case 'open':
            case 'open-reschedule':
            case 'pending':
            case 'ready_scheduled':
                $this->showSched = true;
                break;
            case 'scheduled':
            case 'in_progress':
            case 'comparative':
            $this->showChangeTech = true;
            $this->showChangeSched = true;
                break;
            case 'uploading':
            case 'uploading_pics':
            case 'preparing_billing':
            case 'review':
            case 'ready_to_bill':
            case 'revise_to_bill':
            case 'no_job':
            case 'billed':
            case 'partial_paid':
            case 'paid':
            case 'closed':
            case 'lien':
                $this->showChangeTech = true;
                break;
            default:
                break;
        }


    }
    public function render()
    {
        return view('assignments::livewire.show.header-scheduling');
    }
}
