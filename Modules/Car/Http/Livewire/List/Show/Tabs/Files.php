<?php

namespace Modules\Car\Http\Livewire\List\Show\Tabs;

use Livewire\Component;
use Modules\Car\Entities\Car;

class Files extends Component
{

    public $car;
    public $types = [];

    public function mount(Car $car)
    {
        $this->car = $car;
        $this->types = config('car.types');
    }

    public function render()
    {
        return view('car::livewire.list.show.tabs.files');
    }
}
