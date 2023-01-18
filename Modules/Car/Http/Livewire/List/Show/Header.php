<?php

namespace Modules\Car\Http\Livewire\List\Show;

use Livewire\Component;
use Modules\Car\Entities\Car;


class Header extends Component
{
    protected $listeners = [
        'showUpdateinfo' => 'processShowinfo',
    ];

    public $car;
    public $show = true;

    // fields
    public $auto;
    public $driver;


    protected $rules = [
        'auto' => 'required',
        'driver' => 'required',
    ];
    public function mount(Car $car)
    {
        $this->car = $car;
        $this->auto = $this->car->auto;
        $this->driver = $this->car->driver;

    }
    public function update($formData){
        $this->validate();
        $errors = $this->getErrorBag();

        $id =  $this->car->id;
        $update = $this->car->update($formData);

        $this->car = Car::find($id);
        session()->flash('alert' ,[
            'class' => 'success',
            'message' => "Car Info #$id successfully updated.."
        ]);

        $this->show = true;

    }
    public function processShowinfo(){
        $this->show = false;
    }
    public function render()
    {
        return view('car::livewire.list.show.header');
    }
}
