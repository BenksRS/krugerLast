<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Info;

use Auth;
use Carbon\Carbon;
use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Notes\Entities\Note;
use Modules\Referrals\Entities\Referral;

class Notes extends Component
{
    protected $listeners = [
        'updateNotes',
        'sendCC',
        'postComment'
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

    public function sendCC($id){
        $note = Note::find($id);

        // alacrity time zone
        switch ($this->assignment->state){
            case 'LA':
                $ContactDate=Carbon::createFromFormat('Y-m-d H:i:s', $note->created_at)->subHours(1)->format('Y-m-d H:i:s');
            break;
            default:
                $ContactDate=Carbon::createFromFormat('Y-m-d H:i:s', $note->created_at)->format('Y-m-d H:i:s');
            break;
        }

        $data['cc_alacnet']='Y';
        $update = $note->update($data);



        alacrity_service()->post('UpdateDates',['AssignmentId'=> $this->assignment->allacrity_id],
            ["AssignmentDates" =>[
                'ContactDate'=> $ContactDate
            ]]);

        $this->updateNotes();
        $this->emit('contentCC');

    }
    public function postComment($id){
        $note = Note::find($id);

        $name= $note->user->name;
        alacrity_service()->post('AddComment',['AssignmentId'=> $this->assignment->allacrity_id],
            ["Comment" =>[
                'CommentString'=> "$note->text\n `by $name",
                'CommentTypeId'=> 1,
            ]]);


        $data['post_alacnet']='Y';
        $update = $note->update($data);

        $this->updateNotes();
        $this->emit('contentCC');

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
