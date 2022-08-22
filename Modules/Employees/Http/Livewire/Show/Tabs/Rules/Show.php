<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Rules;

use Livewire\Component;
use Modules\Employees\Entities\EmployeeRules;
use Modules\User\Entities\User;

class Show extends Component
{
    public $user;
    public $rules;
    public $tab='active';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->rules = EmployeeRules::where('user_id',  $this->user->id)->get();
    }

    public function setTab($tab){
        $this->tab=$tab;
    }
    public function disable($id){
        $rule=EmployeeRules::find($id);
        $rule->update(['status'=>'disable']);

        $this->rules = EmployeeRules::where('user_id',  $this->user->id)->get();
    }

    public function active($id){
        $rule=EmployeeRules::find($id);
        $rule->update(['status'=>'active']);

        $this->rules = EmployeeRules::where('user_id',  $this->user->id)->get();
    }
    public function render()
    {
        return view('employees::livewire.show.tabs.rules.show');
    }
}
