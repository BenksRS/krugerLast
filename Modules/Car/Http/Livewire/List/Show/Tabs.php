<?php

namespace Modules\Car\Http\Livewire\List\Show;

use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Modules\Car\Entities\Car;
use Modules\User\Entities\User;

class Tabs extends Component
{

    protected $listeners = [
        'changeTab'       => 'processChangetab',
        'refreshTabPanel' => '$refresh',

    ];

    public    $url;

    public    $user;
    public    $car;

    public    $isActive  = 'manutencao';

    public    $navs      = [
        [
            'title'    => 'Info',
            'href'     => 'info',
            'key'      => 'car_tab_info',
            'tab'      => 'car::list.show.tabs.info',
            'category' => 'all',
        ],
        [
            'title'    => 'Maintenance (Manutenção)',
            'href'     => 'manutencao',
            'key'      => 'car_tab_manutencao',
            'tab'      => 'car::list.show.tabs.manutencao',
            'category' => 'manutencao',
        ],
        [
            'title'    => 'Files',
            'href'     => 'files',
            'key'      => 'car_tab_files',
            'tab'      => 'car::list.show.tabs.files',
            'category' => 'files',
            'category' => 'files',
        ]
    ];

    public function mount(Car $car, User $user)
    {
        $this->car = $car;
        $this->user = $user;
        $this->url  = Route::getCurrentRoute()->uri();

        if ($this->url == 'profile') {
            $this->isActive = 'commission';
        }
    }

    public function processChangetab($newActive)
    {

        $this->isActive = $newActive;
    }

    public function render()
    {
        return view('car::livewire.list.show.tabs');
    }
}
