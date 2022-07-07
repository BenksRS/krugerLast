<?php

namespace Modules\Assignments\Http\Livewire\Show;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Addons\Entities\Assignment\AssignmentStatus;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsScheduling;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Modules\User\Entities\Techs;
use Auth;

class HeaderScheduling extends Component
{
    protected $listeners = [
        'showButtons' => 'toggleButtons',
    ];

    public $showButtons= true;

    public $assignment;
    public $showChangeTech = false;
    public $showSched = false;
    public $showChangeSched = false;

    public $showFormDate = false;
    public $typeForm;


    public $techs;
    public $techSelected;

    public $user;


    public $schedule_start;


    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->techs =Techs::all();
        $this->user = Auth::user();
        $this->checkButons();

    }
    public function toggleButtons($info){
        $this->showButtons = !$this->showButtons;
        $this->typeForm =  $info;
        if($info == 'full'){
            $this->showFormDate = true;
        }else{
            $this->showFormDate = false;
        }
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

    }


    public function ScheduleUpdate(){
        $Schedule=AssignmentsScheduling::where('assignment_id', $this->assignment->id)->first();

        $AssignmentsScheduling=[
            'assignment_id' => $this->assignment->id,
            'tech_id' => $this->techSelected,
            'updated_by' => $this->user->id,
        ];

        if($this->schedule_start){
            $data_start = Carbon::createFromFormat('Y-m-d  H:i', $this->schedule_start)->format('Y-m-d H:i:s');

            $data_end = strtotime($data_start)+60*60;
            $data_end = date('Y-m-d H:i:s', $data_end);

            $AssignmentsScheduling['start_date']=$data_start;
            $AssignmentsScheduling['end_date']=$data_end;
        }



        $Schedule->update($AssignmentsScheduling);

        $this->techSelected = $this->schedule_start = null;

        $this->emit('updateScheduling');
        $this->toggleButtons('back');

    }
    public function scheduleInsert(){

        if($this->schedule_start){
            $data_start = Carbon::createFromFormat('Y-m-d  H:i', $this->schedule_start)->format('Y-m-d H:i:s');
            $data_end = strtotime($data_start)+60*60;
            $data_end = date('Y-m-d H:i:s', $data_end);
        }
        $AssignmentsScheduling=[
            'assignment_id' => $this->assignment->id,
            'tech_id' => $this->techSelected,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
            'start_date' => $data_start,
            'end_date' => $data_end,
        ];
        AssignmentsScheduling::create($AssignmentsScheduling);

        $AssignmentStatus=[
          'assignment_id'  => $this->assignment->id,
          'assignment_status_id'  => 2,
          'created_by'  => $this->user->id,
        ];
        AssignmentsStatusPivot::create($AssignmentStatus);

        $update_status=[
            'status_id'  => 2,
            'updated_by'  => $this->user->id,
        ];
        $this->assignment->update($update_status);

        $this->emit('updateScheduling');
        $this->toggleButtons('back');
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
