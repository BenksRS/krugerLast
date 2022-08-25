<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\Employees\Entities\EmployeeRate;
use Modules\Employees\Http\Livewire\Show\Tabs\Rates\Edit;
use Modules\User\Entities\User;


class Rates extends Component
{
    protected $listeners = [
        'toggleShowRates'
    ];
    public $show=true;
    public $user;
    public $rate;



    public function mount(User $user)
    {
        $this->user = $user;
        $this->checkRate();
    }
    public function checkRate()
    {
        $this->rate = EmployeeRate::where('user_id', $this->user->id)->first();

        if (!$this->rate) {
            EmployeeRate::create(['user_id' => $this->user->id, 'type' => 'D'])->save();
            $this->rate = EmployeeRate::where('user_id', $this->user->id)->first();
        }
    }
    public function toggleShowRates(){
        $this->show = !$this->show;
    }
    public function render()
    {
        return view('employees::livewire.show.tabs.rates');
    }
}
