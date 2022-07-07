<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Finance;

use Livewire\Component;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;

class Collection extends Component
{
    protected $listeners = [
        'balanceReload' => 'processBalance',
    ];
    public $assignment;

    public function mount(AssignmentFinanceRepository $assignment)
    {
        $this->assignment = $assignment;
    }
    public function processBalance(){
        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);
//        $this->emit('updateScheduling');
    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.finance.collection');
    }
}
