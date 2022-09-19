<?php

namespace Modules\Assignments\Http\Livewire\General;

use Livewire\Component;
use Modules\Assignments\Entities\AssignmentsEvents;
use Modules\Assignments\Entities\AssignmentsPhones;
use Modules\Assignments\Entities\AssignmentsTags;

class Tags extends Component
{
    public $tags;
    public $new_tag;
    public $new_event;
    public $events;
    public $addTag=false;
    public $addEvent=false;

    public function mount(){
        $this->tags = AssignmentsTags::all();
        $this->events = AssignmentsEvents::all();
    }

    public function addTags(){
        $this->addTag=!$this->addTag;
    }
    public function addEvents(){
        $this->addEvent=!$this->addEvent;
    }
    public function addNewTag(){
        AssignmentsTags::create([
            'name' => strtoupper($this->new_tag),
            'active' => 'Y',
        ])->save();
        $this->new_tag = null;
        $this->addTags();
        $this->tags = AssignmentsTags::all();
    }
    public function addNewEvent(){
        AssignmentsEvents::create([
            'name' => strtoupper($this->new_event),
            'active' => 'Y',
        ])->save();
        $this->new_event = null;
        $this->addEvents();
        $this->events = AssignmentsEvents::all();
    }
    public function changeTags($id){
        $tag = AssignmentsTags::find($id);
        $update['active']=($tag->active == 'Y') ? 'N' : 'Y';
        $tag->update($update);

        $this->tags = AssignmentsTags::all();
    }
    public function changeEvents($id){
        $tag = AssignmentsEvents::find($id);
        $update['active']=($tag->active == 'Y') ? 'N' : 'Y';
        $tag->update($update);

        $this->events = AssignmentsEvents::all();
    }
    public function render()
    {
        return view('assignments::livewire.general.tags');
    }
}
