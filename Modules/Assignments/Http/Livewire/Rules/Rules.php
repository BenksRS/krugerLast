<?php

namespace Modules\Assignments\Http\Livewire\Rules;

use Livewire\Component;
use Modules\Assignments\Entities\AssignmentsRules;

class Rules extends Component
{
    public $search;

    protected $listeners = ['$refresh'];

    public function mount(AssignmentsRules $rules)
    {
    }

    public function loadData()
    {
        $query = AssignmentsRules::with(['job_type', 'referral', 'carrier', 'tag']);
        return $query->get();
    }

    public function updatedSearch()
    {
    }

    public function render()
    {
        $rules = $this->loadData();
        return view('assignments::livewire.rules.rules', compact('rules'));
    }
}