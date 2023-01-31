<?php

namespace Modules\Car\Http\Livewire\List;

use Livewire\Component;
use Modules\Car\Entities\Car;

class NewCar extends Component
{

    public $show = true;

    public $auto;
    public $driver;


    public function change(){
        $this->show=!$this->show;
    }
    public function newAuto($formData){
        $data = [
            'auto' => $this->auto,
            'driver' => $this->driver,
        ];


        // INSERT Car
        $created = Car::create($data);

        return redirect()->to("/cars/show/$created->id");
    }
    public function render()
    {
        return view('car::livewire.list.new-car');
    }
}
