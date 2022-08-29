<?php

namespace Modules\Employees\Http\Livewire\Show;

use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Modules\User\Entities\User;


class Header extends Component
{
    public $show = true;
    public $user;
    public $active;
    public $name;
    public $url;


    protected $rules = [
        'name' => 'required',
        'active' => 'required',
    ];
    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->active = $user->active;

        $this->url = \session()->get('url');

    }

    public function edit(){

        $this->show = false;
    }
    public function update($formData){
        $this->validate();

        $errors = $this->getErrorBag();

        $update = $this->user->update($formData);
        $id=$this->user->id;
        $this->user = User::find($id);
        session()->flash('alert' ,[
            'class' => 'success',
            'message' => "User #$id successfully updated.."
        ]);

        $this->show = true;
//        $this->emitTo('referrals::show.tabs-panel', 'refreshTabPanel',['referral' => $id]);
    }
    public function render()
    {
        return view('employees::livewire.show.header');
    }
}
