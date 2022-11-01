<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Auth;

class Account extends Component {

    public $user;

    public $action;

    public $password;

    public function mount ()
    {
        $this->user   = Auth::user();
        $this->action = \session()->get('action');

    }

    public function save ()
    {
        if ( $this->password != NULL ) {
            $this->user->password = $this->password;
            $this->user->save();

            $this->password = NULL;
        }
    }

    public function render ()
    {
        return view('employees::livewire.show.tabs.account');
    }

}
