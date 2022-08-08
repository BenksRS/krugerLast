<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Receipts;
use Auth;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\User\Entities\User;

class Add extends Component
{

    use WithFileUploads;
    public $photo;
    public $auth_user;
    public $user;
    public $amount;
    public $category;

    public function mount(User $user)
    {

        $this->user = $user;
        $this->auth_user = Auth::user();
    }
    public function updated($field)
    {
        $array = array('amount');

        if (in_array($field, $array))
        {
            $this->{$field} = ($this->{$field} != '') ? number_format(preg_replace('/[^0-9.]+/', '', $this->{$field}), 2) : '';

        }
    }
    public function render()
    {
        return view('employees::livewire.show.tabs.receipts.add');
    }
}
