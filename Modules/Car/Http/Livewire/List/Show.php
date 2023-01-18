<?php

namespace Modules\Car\Http\Livewire\List;

use Livewire\Component;
use Modules\Car\Entities\Car;

class Show extends Component
{

    public $car;

    public function mount(Car $car)
    {
        $this->car = $car;
    }
    public function render()
    {
        return view('car::livewire.list.show');
    }
}
