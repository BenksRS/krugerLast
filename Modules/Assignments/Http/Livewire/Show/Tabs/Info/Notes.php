<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Info;

use Auth;
use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Referrals\Entities\Referral;

class Notes extends Component
{
    protected $listeners = [
        'updateNotes'
    ];
    public $assignment;
    public $notesList;
    public $user;
    public $notetext;
    public $showinfo = false;



    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->notesList = $this->assignment->notes->where('type','assignment');
        $this->user = Auth::user();
    }
    public function showAdd(){
        $this->showinfo = true;
    }
    public function updateNotes(){
        $this->assignment = Assignment::find($this->assignment->id);
        $this->notesList = $this->assignment->notes->where('type','assignment');
    }
    public function addNewNote(){

        $this->assignment->notes()->create([
            'text'=> $this->notetext,
            'notable_id'=> $this->assignment->id,
            'created_by'=> $this->user->id,
            'type'=> 'assignment',
            'notable_type'=>  Assignment::class,
        ]);

        $this->notetext = null;
        $this->showinfo = false;

        $this->assignment = Assignment::find($this->assignment->id);
        $this->notesList = $this->assignment->notes->where('type','assignment');

    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.info.notes', [
            'notesListAll' => $this->notesList,
            'show' => $this->showinfo,
        ]);
    }
}
