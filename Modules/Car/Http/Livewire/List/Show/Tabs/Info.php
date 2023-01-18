<?php

namespace Modules\Car\Http\Livewire\List\Show\Tabs;

use Livewire\Component;
use Modules\Car\Entities\Car;

class Info extends Component
{
    public $car;
    public function mount(Car $car)
    {
        $this->car = $car;
    }
    public function render()
    {
        return view('car::livewire.list.show.tabs.info');
    }
}
