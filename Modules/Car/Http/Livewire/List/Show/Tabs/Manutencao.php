<?php

namespace Modules\Car\Http\Livewire\List\Show\Tabs;

use Livewire\Component;
use Modules\Car\Entities\Car;

class Manutencao extends Component
{
    protected $listeners = [
        'addMaintenance' => 'add',
        'backList' => 'showList',
    ];
    public $car;
    public $show=true;

    public function mount(Car $car)
    {
        $this->car = $car;
    }
    public function showList(){
        $this->show = !$this->show;
    }
    public function add(){

        $this->show = !$this->show;

    }
    public function render()
    {
        return view('car::livewire.list.show.tabs.manutencao');
    }

}
