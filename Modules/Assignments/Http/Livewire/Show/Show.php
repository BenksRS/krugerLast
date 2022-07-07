<?php

namespace Modules\Assignments\Http\Livewire\Show;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;

class Show extends Component
{
    public $assignment;
    public $foiiiiii;

    public function mount(Assignment $assignment){
        $this->assignment = $assignment;
        $this->foiiiiii = 'test';
    }
    public function render()
    {
        return view('assignments::livewire.show.show');
    }
}
