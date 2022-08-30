<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\Employees\Entities\EmployeeRules;
use Modules\User\Entities\Techs;
use Modules\User\Entities\User;

class Rules extends Component
{
    protected $listeners = [
        'toggleShowRules'
    ];

    public $show=true;
    public $duplicate=false;
    public $user;
    public $techs;
    public $tech_id;
    public function mount(User $user)
    {
        $this->user = $user;
        $this->techs = Techs::where('active','Y')->get();


    }
    public function toggleDuplicate(){
        $this->duplicate =!$this->duplicate;

    }
    public function duplicate(){

        $rules = EmployeeRules::where('user_id', $this->user->id)->get();

        if($this->tech_id){
            foreach ($rules as $rule){
        //            dd($phone);
                $rule->user_id = $this->tech_id;
                unset($rule->id);
                $clone_rule =  $rule->replicate();
                $clone_rule->save();
            }
        }
        $this->emit('toggleShowRules');

    }
    public function toggleShowRules(){
        $this->show =!$this->show;
    }
    public function render()
    {
        return view('employees::livewire.show.tabs.rules');
    }
}
