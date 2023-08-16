<?php

namespace Modules\Employees\Http\Livewire\List;

use Livewire\Component;
use Modules\User\Entities\User;

class Index extends Component
{
    public $searchEmployes;
    public $url_current;


    public function mount(){
        //        dd($listActive);
        $currenturl = url()->current();
        $currenturl_treated = str_replace("http://krugerlast.sys:8080/", "", $currenturl);
        $this->url_current = str_replace("http://system.callkruger.com/", "", $currenturl_treated);
    }
    public function render()
    {
        $searchEmployes = "%$this->searchEmployes%";
        $listActive=User::With('info')->whereLike('name',$searchEmployes)->where('active','Y')->get();
        $listOff=User::With('info')->whereLike('name',$searchEmployes)->where('active','N')->get();








        return view('employees::livewire.list.index',[
            'list_actives' =>$listActive,
            'list_off' =>$listOff,
        ]);
    }
}







