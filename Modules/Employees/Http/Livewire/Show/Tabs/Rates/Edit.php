<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Rates;

use Livewire\Component;
use Modules\Employees\Entities\EmployeeRate;
use Modules\User\Entities\User;

class Edit extends Component
{

    public $type;
    public $regular_day;
    public $weekend_day;
    public $sleep_out;
    public $hurricane;
    public $oncall;
    public $user;

    public $rate;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->checkRate();
    }
    public function updated($field)
    {
        $array = array('regular_day', 'weekend_day', 'sleep_out', 'hurricane', 'oncall');

        if (in_array($field, $array))
        {
            $this->{$field} = ($this->{$field} != '') ? number_format(preg_replace('/[^0-9.]+/', '', $this->{$field}), 2) : '';
        }
    }
    public function checkRate(){
        $this->rate = EmployeeRate::where('user_id', $this->user->id)->first();

        if(!$this->rate){
            EmployeeRate::create(['user_id'=>$this->user->id, 'type' => 'D'])->save();
            $this->rate = EmployeeRate::where('user_id', $this->user->id)->first();
        }

        $this->type = $this->rate->type;
        $this->regular_day = $this->rate->regular_day;
        $this->weekend_day = $this->rate->weekend_day;
        $this->sleep_out = $this->rate->sleep_out;
        $this->hurricane = $this->rate->hurricane;
        $this->oncall = $this->rate->oncall;

    }
    public function saveRate($formData){

        $this->rate->update($formData);

        $this->checkRate();

        $this->emit('toggleShowRates');

    }
    public function render()
    {
        return view('employees::livewire.show.tabs.rates.edit');
    }
}
