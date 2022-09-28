<?php

namespace Modules\Assignments\Http\Livewire\Show;


use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsEvents;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Entities\AssignmentsStatus;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Modules\Assignments\Entities\AssignmentsTags;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Referrals\Entities\Referral;


use Auth;

class Header extends Component
{
    protected $listeners = [
        'tagsUpdate' => 'processTags',
        'jobtypeUpdate' => 'processJobtype',
        'showUpdateinfo' => 'processShowinfo',
        'updateScheduling' => 'processScheduling',
    ];
    public $show = true;

    public $user;
    public $assignment;
    public $selectedTags;
    public $selectedTags_ids;
    public $allTags;
    public $allEvents;


    public $changeStatustext;

    // job types
    public $jtm;
    public $jts;
    public $jtc;

    // fields
    public $first_name;
    public $last_name;
    public $job_types_selected;

    public $preStatus;
    public $historic;

    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
    ];

    public function mount(Assignment $assignment)
    {

        $this->assignment = $assignment;
        $this->selectedTags = $this->assignment->tags;
        $this->selectedTags_ids = $this->assignment->tags->pluck('id');
        $this->allTags = AssignmentsTags::whereNotIn('id',$this->selectedTags_ids)->where('active', 'y')->get();
        $this->allEvents = AssignmentsEvents::where('active', 'y')->get();

        $this->jtc = AssignmentsJobTypes::where('active', 'y')->get();
        $this->historic = AssignmentsStatusPivot::where('assignment_id',$this->assignment->id)->get();
        $this->first_name = $this->assignment->first_name;
        $this->last_name = $this->assignment->last_name;
        $this->user = Auth::user();
    }


    public function setPreStatus($newStatus){
        $this->preStatus = $newStatus;
    }
    public function changeStatusNojob($newStatus){

        $this->assignment->notes()->create([
            'text'=> $this->changeStatustext,
            'notable_id'=> $this->assignment->id,
            'created_by'=> $this->user->id,
            'type'=> 'no_job',
            'notable_type'=>  Modules\Assignments\Entities\Assignment::class,
        ]);
        $this->changeStatus($newStatus);
        $this->assignment = Assignment::find($this->assignment->id);
        $this->preStatus = $this->changeStatustext = null;

        integration('assignments')->set($this->assignment->id);

        $this->emit('updateNotes');
    }
    public function changeStatusNotes($newStatus){

        $status= AssignmentsStatus::find($newStatus);
        $this->assignment->notes()->create([
            'text'=> "### CHANGE STATUS TO: $status->name ### $this->changeStatustext",
            'notable_id'=> $this->assignment->id,
            'created_by'=> $this->user->id,
            'type'=> 'assignment',
            'notable_type'=>  Modules\Assignments\Entities\Assignment::class,
        ]);

        if(in_array($newStatus, [11,12, 27])){
            if($this->assignment->scheduling){
                $this->assignment->scheduling->delete();
            }
        }


        $this->changeStatus($newStatus);
        $this->assignment = Assignment::find($this->assignment->id);
        $this->preStatus = $this->changeStatustext = null;
        integration('assignments')->set($this->assignment->id);
        $this->emit('updateNotes');

    }
    public function nojob($newStatus){


        $this->assignment->notes()->create([
            'text'=> $this->changeStatustext,
            'notable_id'=> $this->assignment->id,
            'created_by'=> $this->user->id,
            'type'=> 'no_job',
            'notable_type'=>  Modules\Assignments\Entities\Assignment::class,
        ]);
        $this->changeStatus($newStatus);
        $this->assignment = Assignment::find($this->assignment->id);
        $this->preStatus = $this->changeStatustext = null;
        integration('assignments')->set($this->assignment->id);
        $this->emit('updateNotes');

    }
    public function changeStatus($newStatus){
        $this->preStatus = null;
        if($this->assignment->status_id != $newStatus){
            AssignmentsStatusPivot::create([
                'assignment_id'=> $this->assignment->id,
                'assignment_status_id'=> $newStatus,
                'created_by'=> 73,
            ]);
            $update_status=[
                'status_id'  => $newStatus,
                'updated_by'  => $this->user->id,
            ];

            $status_collection=array(5,6);
            if(in_array($newStatus, $status_collection)){
                $update_status['status_collection_id']=$newStatus;
            }


            $this->assignment->update($update_status);

            $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);

            integration('assignments')->set($this->assignment->id);
            $this->emit('updateScheduling');
        }
    }

    public function changeStatusScheduling($newStatus){
        $this->preStatus = null;
        if($this->assignment->status_id != $newStatus){
            AssignmentsStatusPivot::create([
                'assignment_id'=> $this->assignment->id,
                'assignment_status_id'=> $newStatus,
                'created_by'=> 73,
            ]);
            $update_status=[
                'status_id'  => $newStatus,
                'updated_by'  => $this->user->id,
            ];

            $status_collection=array(5,6);
            if(in_array($newStatus, $status_collection)){
                $update_status['status_collection_id']=$newStatus;
            }

            $this->assignment->update($update_status);
            $this->assignment->scheduling->delete();

            $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);

            integration('assignments')->set($this->assignment->id);
            $this->emit('updateScheduling');
        }
    }

    public function processScheduling(){
        $this->assignment = Assignment::find($this->assignment->id);
        $this->historic = AssignmentsStatusPivot::where('assignment_id',$this->assignment->id)->get();
        //sync app
//        callkruger('jobs')->sync($this->assignment->id);

    }
    public function processShowinfo(){
        $this->show = false;
    }
    public function update($formData){
        $this->validate();
        $errors = $this->getErrorBag();

        $id =  $this->assignment->id;
        $update = $this->assignment->update($formData);

        $this->assignment = Assignment::find($id);
        session()->flash('alert' ,[
            'class' => 'success',
            'message' => "Assignment #$id successfully updated.."
        ]);
//        sleep(0.5);

        $this->show = true;

    }
    public function processJobtype($id){
        $this->assignment = Assignment::find($id);
    }
    public function processTags($id){
        $this->assignment = Assignment::find($id);
        $this->selectedTags = $this->assignment->tags;
        $this->selectedTags_ids = $this->assignment->tags->pluck('id');
        $this->allTags = AssignmentsTags::whereNotIn('id',$this->selectedTags_ids)->where('active', 'y')->get();
        $this->dispatchBrowserEvent('closeModal');
    }


    public function addEvent($idEvent){

        $job=Assignment::find($this->assignment->id);

//        dd($idEvent);
        $job->update(['event_id' => $idEvent]);

        $this->assignment = Assignment::find($this->assignment->id);
        integration('assignments')->set($this->assignment->id);
    }
    public function addTag($idTag){
        $this->assignment->tags()->attach($idTag);
        $this->selectedTags = $this->assignment->tags;
        $this->selectedTags_ids = $this->assignment->tags->pluck('id');
        $this->emit('tagsUpdate',$this->assignment->id);
        $this->dispatchBrowserEvent('close-modal');
        integration('assignments')->set($this->assignment->id);
    }
    public function removeTag($idTag){
        $this->assignment->tags()->detach($idTag);
        $this->selectedTags = $this->assignment->tags;
        $this->selectedTags_ids = $this->assignment->tags->pluck('id');
        $this->emit('tagsUpdate',$this->assignment->id);
        integration('assignments')->set($this->assignment->id);
    }

    public function render()
    {
        return view('assignments::livewire.show.header');
    }
}
