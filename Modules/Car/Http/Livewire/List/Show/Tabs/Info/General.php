<?php

namespace Modules\Car\Http\Livewire\List\Show\Tabs\Info;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Car\Entities\Car;

class General extends Component
{
    protected $listeners = [
    'editGeneral' => 'edit',
];
    public $show=true;

    public   $car;
    public   $make;
    public   $plate;
    public   $vin;
    public   $year;
    public   $epass;
    public   $model;

    public   $tag_expires;


    public function mount(Car $car)
    {
        $this->car = $car;

        $this->make = $this->car->make;
        $this->plate = $this->car->plate;
        $this->vin = $this->car->vin;
        $this->year = $this->car->year;
        $this->epass = $this->car->epass;
        $this->model = $this->car->model;

        $this->tag_expires = $this->car->tag_expires;
    }
    public function update($formData){

        $id =  $this->car->id;
        $update = $this->car->update($formData);


        session()->flash('alert' ,[
            'class' => 'success',
            'message' => "Car General Info successfully updated.."
        ]);
        $this->car = Car::find($id);

        $this->make = $this->car->make;
        $this->plate = $this->car->plate;
        $this->vin = $this->car->vin;
        $this->year = $this->car->year;
        $this->epass = $this->car->epass;
        $this->model = $this->car->model;

        $this->show = true;
    }
    public function edit(){

        $this->show = !$this->show;

    }

    public function render()
    {
        return view('car::livewire.list.show.tabs.info.general');
    }
}