<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Finance;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;

class Collection extends Component
{
    protected $listeners = [
        'balanceReload' => 'processBalance',
    ];
    public $assignment;
    public $showFollowUp=true;
    public $follow_up_date;

    public function mount(AssignmentFinanceRepository $assignment)
    {
        $this->assignment = $assignment;
        $this->follow_up_date = $this->assignment->follow_up;
    }
    public function updateFollowup($formData){

        $this->assignment->update($formData);
        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);
        $this->toggleFollowup();
    }


    public function toggleFollowup(){

        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);
        $this->showFollowUp=!$this->showFollowUp;

        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);

    }
    public function processBalance(){
        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);

    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.finance.collection');
    }
}
