<?php

namespace Modules\Employees\Http\Livewire\List;

use Livewire\Component;
use Modules\User\Entities\User;

class Index extends Component
{
    public $searchEmployes;


    public function render()
    {
        $searchEmployes = "%$this->searchEmployes%";
        $listActive=User::whereLike('name',$searchEmployes)->where('active','Y')->get();
        $listOff=User::whereLike('name',$searchEmployes)->where('active','N')->get();

        return view('employees::livewire.list.index',[
            'list_actives' =>$listActive,
            'list_off' =>$listOff,
        ]);
    }
}







