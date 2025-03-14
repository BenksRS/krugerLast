<?php

namespace Modules\Password\Http\Livewire;

use Livewire\Component;
use Modules\Password\Entities\Password;

class ShowAdmin extends Component {

    public    $search;

    protected $listeners = ['$refresh'];

    public function render()
    {
        $passwords = Password::with(['user_created', 'user_updated'])
            ->where('is_admin', 'Y')
            ->where(function($query) {
                $query->when($this->search, function($query, $search) {
                    $query->where('name', 'like', '%'.$search.'%')
                          ->orWhere('url', 'like', '%'.$search.'%')
                          ->orWhere('username', 'like', '%'.$search.'%');
                });
            })
            ->orderBy('name')->get();

        return view('password::livewire.show-admin', compact('passwords'));
    }

}