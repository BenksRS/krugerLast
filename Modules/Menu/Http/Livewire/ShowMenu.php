<?php

namespace Modules\Menu\Http\Livewire;


use Livewire\Component;
use Modules\Menu\Entities\MenuLink;
use Auth;

class ShowMenu extends Component {

    public $links;

    public $user;

    public function mount ()
    {
        $this->user = Auth::user();
//        dd($this->user);

        $this->getLinkGroup();
    }

    public function getLinkGroup ()
    {
        $links = collect();

        if ($groupId = $this->user->group?->id) {
            $filter = fn ($q) => $q->where('group_id', $groupId)->where('visible', 'Y');

            $links = MenuLink::with(['group' => $filter])
                ->whereHas('group', $filter)
                ->get()
                ->each(fn ($link) => $link->order = $link->group?->order);
        }

        $this->links = $links
            ->each(fn ($link) => $link->children = $links
                ->where('link_id', $link->id)
                ->sortBy('order')
                ->values()
            )
            ->whereNull('link_id')
            ->values();
    }

    public
    function render ()
    {
        return view('menu::livewire.show-menu');
    }

}