<?php

namespace Modules\Password\Http\Livewire\Modal;

use Livewire\Component;
use Modules\Password\Entities\Password;

class Form extends Component {

    public    $password;

    public    $password_id;

    protected $rules     = [
        'password.name'     => 'required',
        'password.url'      => 'required',
        'password.username' => 'required',
        'password.password' => 'required',
    ];

    protected $listeners = ['passwordForm' => 'show'];

    public function show(Password $password)
    {
        $this->reset();

        if ($password->id) {
            $this->password_id = $password->id;
            $this->password    = $password;
        }
        $this->emit('openModal');
    }

    public function save()
    {
        $this->validate();
        $this->password['is_admin'] = 'N';
        if ($this->password_id) {
            $this->password->save();
        } else {
            Password::create($this->password);
        }
        $this->emit('hideModal');
        $this->emitTo('password::show', '$refresh');
        $this->reset();
    }

    public function render()
    {
        return view('password::livewire.modal.form');
    }

}