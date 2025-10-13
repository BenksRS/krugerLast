<?php

namespace Modules\Assignments\Http\Livewire\Show;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsEvents;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Entities\AssignmentsStatus;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Modules\Assignments\Entities\AssignmentsTags;
use Modules\Assignments\Entities\AssugnmentsMylist;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Assignments\Traits\HandlesAssignmentRules;
use Modules\Notes\Entities\Note;
use Modules\Referrals\Entities\Referral;

use Auth;

class Header extends Component
{
    use HandlesAssignmentRules;
    protected $listeners = [
        'tagsUpdate' => 'processTags',
        'jobtypeUpdate' => 'processJobtype',
        'showUpdateinfo' => 'processShowinfo',
        'updateScheduling' => 'processScheduling',
        'startBilling' => 'processStartBilling',
        'addAuth' => 'processAddAuth',
        'removeAuth' => 'processRemoveAuth',
        'resetBilling' => 'processResetBilling',
        'checkMylist' => 'processMylist',
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
    public $check_mylist;

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

        $this->check_mylist=AssugnmentsMylist::where('assignment_id',$this->assignment->id)->where('user_id',$this->user->id)->first();
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
    public function processMylist(){

        $checkMylist=AssugnmentsMylist::where('assignment_id',$this->assignment->id)->where('user_id',$this->user->id)->first();
        if(isset($checkMylist)){
            $checkMylist->delete();
        }else{
            AssugnmentsMylist::create([
                'assignment_id'=> $this->assignment->id,
                'user_id'=> $this->user->id,
            ]);
        }

        $this->check_mylist=AssugnmentsMylist::where('assignment_id',$this->assignment->id)->where('user_id',$this->user->id)->first();


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
		
		public function changeStatusCleanUp($newStatus, $jobType){
			
			$jobTypes = [16, 17];
			if(in_array($jobType, $jobTypes)){
				$this->assignment->job_types()->detach($jobTypes);
				$this->assignment->job_types()->attach($jobType);
			}
			$status= AssignmentsStatus::find($newStatus);
			$this->assignment->notes()->create([
				'text'=> "### CHANGE STATUS TO: $status->name ### $this->changeStatustext",
				'notable_id'=> $this->assignment->id,
				'created_by'=> $this->user->id,
				'type'=> 'assignment',
				'notable_type'=>  Modules\Assignments\Entities\Assignment::class,
			
			]);

			$this->changeStatus($newStatus);
			$this->assignment = Assignment::find($this->assignment->id);
			$this->preStatus = $this->changeStatustext = null;
			integration('assignments')->set($this->assignment->id);
			$this->emit('updateNotes');

		}
	public function changeStatusMissingAssignment($newStatus){
		AssignmentsStatusPivot::create([
			'assignment_id'=> $this->assignment->id,
			'assignment_status_id'=> $newStatus,
			'created_by'=> 73,
		]);
		$update_status=[
			'status_id'  => $newStatus,
			'updated_by'  => $this->user->id,
		];
		
		
		$this->assignment->update($update_status);
		
		$this->assignment = AssignmentFinanceRepository::find($this->assignment->id);
		
		integration('assignments')->set($this->assignment->id);
		$this->emit('updateScheduling');
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

            // Process Assignment Rules
            if(in_array($newStatus, [1, 11, 12, 33])){
                $this->processAssignmentRules($this->assignment->id);
            }

            integration('assignments')->set($this->assignment->id);
            $this->emit('updateScheduling');

        }
    }

    public function changeStatusScheduling($newStatus){
        $this->preStatus = null;
		    if(in_array($newStatus, [37])){
			    $this->createStatusNotes($newStatus);
		    }
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

            if($this->assignment->scheduling) {
                $this->assignment->scheduling->delete();
            }

            $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);

            if($newStatus == 55) {

                $hoje=Carbon::now();
                $formatado = $hoje->format('m/d/Y H:i:s');
                $statutext = "{$formatado} by {$this->user->id}";

                $status= AssignmentsStatus::find($newStatus);
                $this->assignment->notes()->create([
                    'text'=> "### CHANGE STATUS TO: $status->name ### $statutext",
                    'notable_id'=> $this->assignment->id,
                    'created_by'=> $this->user->id,
                    'type'=> 'assignment',
                    'notable_type'=>  Modules\Assignments\Entities\Assignment::class,
                ]);
                $this->emit('updateNotes');
            }

            integration('assignments')->set($this->assignment->id);
            $this->emit('updateScheduling');
        }
    }
		
		protected function createStatusNotes($newStatus){
			$status= AssignmentsStatus::find($newStatus);
			$this->assignment->notes()->create([
				'text'=> "### CHANGE STATUS TO: $status->name ### $this->changeStatustext",
				'notable_id'=> $this->assignment->id,
				'created_by'=> $this->user->id,
				'type'=> 'assignment',
				'notable_type'=>  Modules\Assignments\Entities\Assignment::class,
			]);
			$this->emit('updateNotes');
		}

    public function processScheduling(){
        $this->assignment = Assignment::find($this->assignment->id);
        $this->historic = AssignmentsStatusPivot::where('assignment_id',$this->assignment->id)->get();
        //sync app
//        callkruger('jobs')->sync($this->assignment->id);

    }
    public function processResetBilling(){
        $id =  $this->assignment->id;

        $data['billed_by']=NULL;
        $this->assignment->update($data);

        $this->assignment = Assignment::find($id);
    }
    public function processStartBilling(){
         $id =  $this->assignment->id;

         $data['billed_by']=$this->user->id;
         $this->assignment->update($data);

        $this->assignment = Assignment::find($id);

    }

    public function processAddAuth(){
        $id =  $this->assignment->id;

        $hoje=Carbon::now();
        $data['auth_needed']='Y';
        $data['auth_needed_by']=null;
        $data['auth_needed_at']=null;
        $this->assignment->update($data);

        $this->assignment = Assignment::find($id);
        integration('assignments')->set($this->assignment->id);

    }
    public function processRemoveAuth(){
        $id =  $this->assignment->id;

        $hoje=Carbon::now();
        $data['auth_needed']='N';
        $data['auth_needed_by']=$this->user->id;
        $data['auth_needed_at']=$hoje;
        $this->assignment->update($data);

        $this->assignment = Assignment::find($id);
        integration('assignments')->set($this->assignment->id);

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