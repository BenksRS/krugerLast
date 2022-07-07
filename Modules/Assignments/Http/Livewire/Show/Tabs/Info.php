<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;

class Info extends Component
{
    public $assignment;
    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.info');
    }
}
