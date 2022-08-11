<?php

namespace Modules\Assignments\Http\Livewire\Show;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsJobTypes;

class Jobtypes extends Component
{
    public $assignment;
    public $jbSelected;
    public $jbSelectedSingle;
    public $jobTypes;

    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->jbSelected = $this->assignment->job_types;
        $this->jbSelectedSingle = $this->assignment->job_types()->where('type', 'S')->get();

        $this->jobTypes = AssignmentsJobTypes::where('active', 'y')->get();
    }
    public function update($id)
    {
         if($this->jbSelected->contains($id)){
             // deattach
             $this->assignment->job_types()->detach($id);

         }else{
             // attach
             $this->assignment->job_types()->attach($id);
         }

        $this->assignment = Assignment::find($this->assignment->id);
        $this->jbSelected = $this->assignment->job_types;
        $this->jbSelectedSingle = $this->assignment->job_types()->where('type', 'S')->get();

        integration('assignments')->set($this->assignment->id);

        $this->emit('jobtypeUpdate',$this->assignment->id);

    }
    public function render()
    {
        return view('assignments::livewire.show.jobtypes');
    }
}
