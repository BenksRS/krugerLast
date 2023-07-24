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
        $listActive=User::With('info')->whereLike('name',$searchEmployes)->where('active','Y')->get();
        $listOff=User::With('info')->whereLike('name',$searchEmployes)->where('active','N')->get();


//        dd($listActive);

        return view('employees::livewire.list.index',[
            'list_actives' =>$listActive,
            'list_off' =>$listOff,
        ]);
    }
}







