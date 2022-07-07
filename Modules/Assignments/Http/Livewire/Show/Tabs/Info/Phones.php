<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Info;

use Livewire\Component;
use Manny\Manny;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsPhones;

class Phones extends Component
{
    public $assignment;
    public $listPhones;

    public $contact;
    public $phone;

    public $edit_id = null;
    public $phone_edit = null;
    public $contact_edit = null;


    protected $rules = [
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
    ];


    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->listPhones = $this->assignment->phones;
        $this->contact = null;
        $this->phone = null;

    }
    public function updated($field)
    {
        if ($field == 'phone')
        {
            $this->phone = Manny::mask($this->phone, "(111) 111-1111");
        }
        if ($field == 'phone_edit')
        {
            $this->phone_edit = Manny::mask($this->phone_edit, "(111) 111-1111");
        }
    }
    public function editPhone($edit_id){
        $this->edit_id = $edit_id;

        $this->assignment = Assignment::find($this->assignment->id);

        $PhonesInfo = AssignmentsPhones::find($edit_id);
        $this->phone_edit = $PhonesInfo->phone;
        $this->contact_edit = $PhonesInfo->contact;

        $this->listPhones = $this->assignment->phones;

    }
    public function update(){


        $assignmentPhone =  AssignmentsPhones::find($this->edit_id);
        $assignmentPhone->update([
            "contact" => $this->contact_edit,
        ]);

        $this->assignment = Assignment::find($this->assignment->id);
        $this->edit_id = null;
        $this->contact_edit = null;
        $this->phone_edit = null;
        $this->listPhones = $this->assignment->phones;
    }

    public function deletePhone($id_delete){
        $phoneDelete = AssignmentsPhones::findorfail($id_delete);
        $phoneDelete->delete();
        $this->assignment = Assignment::find($this->assignment->id);
        $this->listPhones = $this->assignment->phones;

    }
    public function addPhone(){
        $this->validate();

        $errors = $this->getErrorBag();

        AssignmentsPhones::create([
            'assignment_id' => $this->assignment->id,
            'phone' => $this->phone,
            'contact' =>$this->contact,
        ])->save();

        $this->contact = $this->phone = '';
        $this->assignment = Assignment::find($this->assignment->id);
        $this->listPhones = $this->assignment->phones;

    }

    public function render()
    {
        return view('assignments::livewire.show.tabs.info.phones', [
            'listPhones' => $this->listPhones
        ]);
    }
}
