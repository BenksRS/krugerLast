<?php

namespace Modules\Password\Http\Livewire;

use Livewire\Component;
use Modules\Password\Entities\Password;

class Show extends Component {

    public    $is_admin;

    public    $search;

    protected $listeners = ['$refresh'];

    public function mount($is_admin = FALSE)
    {
        $this->is_admin = $this->checkIsAdmin($is_admin);
    }

    protected function checkIsAdmin($is_admin)
    {
        return !$is_admin ? 'N' : 'Y';
    }

    public function render()
    {
        $passwords = Password::with(['user_created', 'user_updated'])
            ->where('is_admin', $this->is_admin)
            ->where(function($query) {
                $query->when($this->search, function($query, $search) {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('url', 'like', '%'.$search.'%')
                        ->orWhere('username', 'like', '%'.$search.'%');
                });
            })
            ->orderBy('name')->get();

        return view('password::livewire.show', compact('passwords'));
    }

}