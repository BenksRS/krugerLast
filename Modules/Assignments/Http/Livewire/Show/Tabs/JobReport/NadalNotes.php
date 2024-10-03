<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\JobReport;

use Auth;
use Livewire\Component;
use Modules\Assignments\Entities\Assignment;

class NadalNotes extends Component
{
    protected $listeners = [
        'updateNotes'
    ];
    public $assignment;
    public $notesList;
    public $user;
    public $notetext;
    public $showinfo = false;
		public $titleNotes = 'Nadal and Gus Notes';



    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->notesList = $this->assignment->notes->where('type','nadal');
//dd($this->notesList);
        $this->user = Auth::user();
    }
    public function showAdd(){
        $this->showinfo = true;
    }
    public function updateNotes(){
        $this->assignment = Assignment::find($this->assignment->id);
        $this->notesList = $this->assignment->notes->where('type','nadal');
    }
    public function addNewNoteNadal(){

        $this->assignment->notes()->create([
            'text'=> $this->notetext,
            'notable_id'=> $this->assignment->id,
            'created_by'=> $this->user->id,
            'type'=> 'nadal',
            'notable_type'=>  Assignment::class,
        ]);

        $this->notetext = null;
        $this->showinfo = false;

        $this->assignment = Assignment::find($this->assignment->id);
        $this->notesList = $this->assignment->notes->where('type','nadal');

        if(in_array($this->assignment->status_id, [2,3])){
            integration('assignments')->set($this->assignment->id);
        }

    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.job-report.nadal-notes', [
            'notesListAll' => $this->notesList,
            'show' => $this->showinfo,
        ]);
    }
}
