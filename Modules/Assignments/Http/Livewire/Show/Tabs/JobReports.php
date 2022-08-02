<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;

class JobReports extends Component
{
    protected $listeners = [
        'jobtypeUpdate' => 'processJobtype',
    ];

    public $assignment;
    public $noJob;

    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->noJob = $this->assignment->notes->where('type','no_job');
//        dd($this->noJob); teste
    }
    public function processJobtype($id){
        $this->assignment = Assignment::find($id);
        $this->noJob = $this->assignment->notes->where('type','no_job');
    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.job-reports');
    }
}
