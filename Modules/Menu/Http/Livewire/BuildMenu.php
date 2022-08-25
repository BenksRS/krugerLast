<?php

namespace Modules\Menu\Http\Livewire;

use Livewire\Component;
use Modules\Menu\Entities\MenuLink;
use Modules\User\Entities\UserGroup;

class BuildMenu extends Component {

    public    $data;

    public    $groups;

    public    $groupActive;

    public    $showForm = FALSE;

    protected $rules    = [
        'data.title'   => 'required',
        'data.icon'    => '',
        'data.url'     => '',
        'data.link_id' => '',
    ];

    public function mount ()
    {
        $this->groups = UserGroup::all();
    }

    public function toogleForm ()
    {
        $this->data     = [];
        $this->showForm = !$this->showForm;
    }

    public function setGroup ($id)
    {
        $this->groupActive = $id;
    }

    public function createLink ()
    {
        MenuLink::create($this->data);
        $this->toogleForm();
    }

    public function getLinks ()
    {
        $links   = MenuLink::query()->get();
        $parents = $links->pluck('title', 'id');

        if ( $this->groupActive ) {
            $group = $links->load(['group' => fn ($query) => $query->where('group_id', $this->groupActive)]);
            $links = $group->map(function ($value) {
                if ( !empty($value->group) ) {

                    $group = $value->group;

                    $value->order  = $group->order;
                    $value->active = $group->visible;

                }

                return $value;
            });
        }

        $links = $links->map(function ($value) use ($links) {
            $value->children = $links->where('link_id', $value->id);

            return $value;

        })->whereNull('link_id');

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
