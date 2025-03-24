<?php

namespace Modules\Password\Http\Livewire\Modal;

use Livewire\Component;
use Modules\Password\Entities\Password;

class Form extends Component {

    public    $is_admin = 'N';

    public    $password;

    public    $password_id;

    protected $rules     = [
        'password.name'     => 'required',
        'password.url'      => 'required',
        'password.username' => 'required',
        'password.password' => 'required',
    ];

    protected $listeners = ['passwordForm' => 'show'];

    public function mount($is_admin = 'N')
    {
        $this->is_admin = $is_admin;
    }

    public function show(Password $password)
    {
        $this->resetProperties();

        if ($password->id) {
            $this->password_id = $password->id;
            $this->password    = $password;
        }
        $this->emit('openModal');
    }

    public function save()
    {
        $this->validate();

        if ($this->password_id) {
            $this->password->save();
        } else {
            $this->password['is_admin'] = $this->is_admin;
            Password::create($this->password);
        }
        
        $this->emit('hideModal');
        $this->resetProperties();
        
        $this->emitTo('password::show', '$refresh');

    }

    protected function resetProperties($properties = ['password', 'password_id'])
    {
        $this->reset($properties);
    }

    public function render()
    {
        return view('password::livewire.modal.form');
    }

}