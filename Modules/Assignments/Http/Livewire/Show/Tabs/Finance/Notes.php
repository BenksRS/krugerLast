<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Finance;

use Livewire\Component;
use Auth;
use Modules\Assignments\Entities\Assignment;

class Notes extends Component
{
    public $assignment;
    public $notesList;
    public $user;
    public $notetext;
    public $showinfo = false;

    public $old_paid_info;
    public $old_billing_info;



    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->notesList = $this->assignment->notes->where('type','finance');
        $this->user = Auth::user();

        $this->old_paid_info = $this->assignment->notes->where('type','payment')->first();
        $this->old_billing_info = $this->assignment->notes->where('type','billing')->first();


    }

    public function showAdd(){
        $this->showinfo = true;
    }
    public function addNewNote(){


        $this->assignment->notes()->create([
            'text'=> $this->notetext,
            'notable_id'=> $this->assignment->id,
            'created_by'=> $this->user->id,
            'type'=> 'finance',
            'notable_type'=>  Assignment::class,
        ]);

        $this->notetext = null;
        $this->showinfo = false;

        $this->assignment = Assignment::find($this->assignment->id);
//        sleep(0.5);
        $this->notesList = $this->assignment->notes->where('type','finance');

    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.finance.notes', [
            'notesListAll' => $this->notesList,
            'show' => $this->showinfo,
        ]);
    }
}
