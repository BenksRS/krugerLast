<?php

namespace Modules\Menu\Http\Livewire;

use Livewire\Component;
use Modules\Menu\Entities\MenuLink;
use Modules\User\Entities\UserGroup;

class BuildMenu extends Component {

    protected $listeners = ['some-event' => '$refresh'];

    public    $data;

    public    $groups;

    public    $showForm  = FALSE;

    protected $rules     = [
        'data.title' => 'required',
        'data.icon'  => '',
        'data.url'   => '',
    ];

    public function mount ()
    {
        $this->groups = UserGroup::all();
    }

    public function groupLinks ($id)
    {

        $items = MenuLink::query()->with(['items' => fn ($query) => $query->where('group_id', $id)])->get();

        $map = $items->map(function ($value, $key) {
            if ( !empty($value['items']) ) {
                dump($value['items']['visible']);
            }

            return $value;
        });

        dump($map->toArray());

    }

    public function toogleForm ()
    {
        $this->showForm = !$this->showForm;
    }

    public function createLink ()
    {
        MenuLink::create($this->data);
        $this->toogleForm();
    }

    public function getLinks ()
    {
        $links   = MenuLink::query()->buildItems()->get();
        $parents = $links->pluck('title', 'id');

        return ['links' => $links, 'parents' => $parents];
    }

    public function render ()
    {
        $menu = $this->getLinks();

        return view('menu::livewire.build-menu', [
            'links'   => $menu['links'],
            'parents' => $menu['parents'],
        ]);
    }

}
