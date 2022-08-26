<?php

namespace Modules\Menu\Http\Livewire;

use Livewire\Component;
use Modules\Menu\Entities\MenuLink;

class ShowMenu extends Component {

    public $links;

    public function mount ( ) {
        $this->links = MenuLink::query()->buildItems()->where('active', 'Y')->get();
    }

    public function render ()
    {
        return view('menu::livewire.show-menu');
    }

}
