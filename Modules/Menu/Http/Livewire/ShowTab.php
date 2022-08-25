<?php

namespace Modules\Menu\Http\Livewire;

use Livewire\Component;
use Modules\Employees\Entities\EmployeeTimesheetDay;
use Modules\Menu\Entities\MenuLink;
use Modules\Menu\Entities\MenuLinkGroup;
use Modules\User\Entities\UserGroup;

class ShowTab extends Component
{
    public $group;
    public $links;
    public $parents;

    public function mount($group){


        $this->group=$group ?? null;

        $this->getLinks();
    }
    public function getLinks()
    {
        $links   = MenuLink::query()->get();
        $parents = $links->pluck('title', 'id');

        if (  $this->group ) {
            $group = $links->load(['group' => fn ($query) => $query->where('group_id', $this->group)]);
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

        $this->links = $links;
        $this->parents = $parents;
//        dd( $this->links.25.);

    }


    public function updateItemGroup($item){
$item=(object)$item;
//dd($item);

       $link=MenuLinkGroup::where('group_id',$this->group)->where('link_id',$item->id)->first();

      if($link){
          $link->update(['visible' => $item->active]);
        }else{
          $data=[
              'group_id' => $this->group,
              'link_id' => $item->id,
              'visible' => $item->active,
              'order' => 0,

          ];
          MenuLinkGroup::create($data)->save();

      }

        $this->getLinks();
    }
    public function render()
    {
        return view('menu::livewire.show-tab');
    }
}
