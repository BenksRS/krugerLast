<?php

namespace Modules\Menu\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Menu\Entities\MenuLink;

class ShowMenu extends Component {

    public $links;

    public $user;

    public function mount ()
    {
        $this->user = Auth::user()->load(['group']);

        $this->getLinkGroup();
    }

    public function getLinkGroup ()
    {

        if ( $this->user->group ) {
            $links = MenuLink::query();
            $group = $links->whereHas('group', function ($query) {
                return $query->where('group_id', $this->user->group->id)->where('visible', 'Y');
            })->get();
            $links = $group->map(function ($value) {
                if ( !empty($value->group) ) {

                    $group = $value->group;

                    $value->order  = $group->order;
                }

                return $value;
            });
        }

        $links = $links
            ->map(function ($value) use ($links) {
                $value->children = $links->where('link_id', $value->id);

                return $value;

            })->whereNull('link_id');

        $this->links = $links;
    }

    public
    function render ()
    {
        return view('menu::livewire.show-menu');
    }

}
