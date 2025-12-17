<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Info;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsLinks;

class Links extends Component
{
    public $assignment;
    public $listLinks;

    public $name;
    public $link;

    public $edit_id = null;
    public $name_edit = null;
    public $link_edit = null;


    protected $rules = [
        'link' => 'required'
    ];


    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->listLinks = $this->assignment->links;
        $this->name = null;
        $this->link = null;

    }
    public function updated($field)
    {
        if ($field == 'link')
        {
            $this->link = $this->link;
        }
        if ($field == 'link_edit')
        {
            $this->link_edit = $this->link_edit;
        }
    }
    public function editLink($edit_id){
        $this->edit_id = $edit_id;

        $this->assignment = Assignment::find($this->assignment->id);

        $LinksInfo = AssignmentsLinks::find($edit_id);
        $this->link_edit = $LinksInfo->link;
        $this->name_edit = $LinksInfo->name;

        $this->listLinks = $this->assignment->links;

    }
    public function updateLink(){


        $assignmentLink =  AssignmentsLinks::find($this->edit_id);
        $assignmentLink->update([
            'name' => $this->name_edit,
            'link' => $this->link_edit,
        ]);

        $this->assignment = Assignment::find($this->assignment->id);
        $this->edit_id = null;
        $this->name_edit = null;
        $this->link_edit = null;
        $this->listLinks = $this->assignment->links;
    }

    public function deleteLink($id_delete){
        $linkDelete = AssignmentsLinks::findorfail($id_delete);
        $linkDelete->delete();
        $this->assignment = Assignment::find($this->assignment->id);
        $this->listLinks = $this->assignment->links;

    }
    public function addLink(){
        $this->validate();

        $errors = $this->getErrorBag();

        AssignmentsLinks::create([
            'assignment_id' => $this->assignment->id,
            'link' => $this->link,
            'name' =>$this->name,
        ])->save();

        $this->name = $this->link = '';
        $this->assignment = Assignment::find($this->assignment->id);
        $this->listLinks = $this->assignment->links;

    }

    public function render()
    {
        return view('assignments::livewire.show.tabs.info.links', [
            'listLinks' => $this->listLinks
        ]);
    }
}