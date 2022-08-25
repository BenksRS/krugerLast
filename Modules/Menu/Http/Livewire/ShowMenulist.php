<?php

namespace Modules\Menu\Http\Livewire;

use Livewire\Component;
use Modules\Menu\Entities\MenuLink;

class ShowMenulist extends Component
{

    public $links;
    public $parents;


    public function mount(){
        $this->getLinks();
    }
    public function getLinks(){
        $links   = MenuLink::query()->get();
        $parents = $links->pluck('title', 'id');

        $links = $links->map(function ($value) use ($links) {
            $value->children = $links->where('link_id', $value->id);

            return $value;

        })->whereNull('link_id');

        $this->links = $links;
        $this->parents = $parents;
    }
    public function render()
    {
        return view('menu::livewire.show-menulist');
    }
}
