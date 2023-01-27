<?php

namespace Modules\Car\Http\Livewire\List\Show\Tabs\Manutencao;

use Livewire\Component;
use Modules\Car\Entities\Car;
use Modules\Car\Entities\CarsChanges;
use Modules\Car\Entities\CarsLogs;

class ListAll extends Component
{
    public $car;
    public $carLogs;
    public $carChanges;

    public function mount(Car $car)
    {
        $this->car = $car;
        $this->carLogs = CarsLogs::where('car_id',$this->car->id)->get();
        $this->carChanges = CarsChanges::all();

    }
    public function render()
    {
        return view('car::livewire.list.show.tabs.manutencao.list-all');
    }
}
