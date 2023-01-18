<?php

namespace Modules\Car\Http\Livewire\List\Show\Tabs\Info;

use Livewire\Component;
use Modules\Car\Entities\Car;

class Insurance extends Component
{
    protected $listeners = [
        'editInsurance' => 'edit',
    ];
    public $show=true;

    public   $car;
    public   $insurance_policy;
    public   $insurance_expires;
    public   $insurance_amount_monthly;



    public function mount(Car $car)
    {
        $this->car = $car;

        $this->insurance_policy = $this->car->insurance_policy;
        $this->insurance_amount_monthly = $this->car->insurance_amount_monthly;
        $this->insurance_expires = $this->car->insurance_expires;

    }
    public function update($formData){

        $id =  $this->car->id;
        $update = $this->car->update($formData);


        session()->flash('alert' ,[
            'class' => 'success',
            'message' => "Car Insurance Info successfully updated.."
        ]);
        $this->car = Car::find($id);

        $this->insurance_policy = $this->car->insurance_policy;
        $this->insurance_amount_monthly = $this->car->insurance_amount_monthly;
        $this->insurance_expires = $this->car->insurance_expires;

        $this->show = true;
    }
    public function edit(){

        $this->show = !$this->show;

    }
    public function render()
    {
        return view('car::livewire.list.show.tabs.info.insurance');
    }
}
