<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Auth;

class CraneNeeded extends Component
{
    public $assignment;
    public $user;

    protected $rules = [
        'assignment.crane_needed' => 'required|in:Y,N',
        'assignment.crane_nadal' => 'nullable',
        'assignment.crane_request' => 'nullable',
        'assignment.crane_notes' => 'nullable',
    ];

    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->user = Auth::user();
    }

    public function getHasChangesProperty()
    {
        return $this->assignment->isDirty([
            'crane_needed',
            'crane_nadal',
            'crane_request',
            'crane_notes',
        ]);
    }

    public function save()
    {
        $this->validate();

        $this->assignment->save();

        $this->emit('craneNeededSaved');
    }

    public function render()
    {
        return view('assignments::livewire.show.tabs.crane-needed');
    }
}