<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Auth;

class CraneNeeded extends Component
{
    public $assignment;
    public $user;

    public $crane_needed;
    public $crane_nadal;
    public $crane_request;
    public $crane_notes;

    protected $rules = [
        'crane_needed' => 'required|in:Y,N',
        'crane_nadal' => 'nullable',
        'crane_request' => 'nullable',
        'crane_notes' => 'nullable',
    ];

    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->user = Auth::user();

        $this->crane_needed = $this->assignment->crane_needed ?? 'N';
        $this->crane_nadal = $this->assignment->crane_nadal;
        $this->crane_request = $this->assignment->crane_request;
        $this->crane_notes = $this->assignment->crane_notes;
    }

    public function save()
    {
        $this->validate();

        $this->assignment->update([
            'crane_needed' => $this->crane_needed,
            'crane_nadal' => $this->crane_nadal,
            'crane_request' => $this->crane_request,
            'crane_notes' => $this->crane_notes,
        ]);
        $this->emit('craneNeededSaved');
    }

    public function render()
    {
        return view('assignments::livewire.show.tabs.crane-needed');
    }
}