<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Receipts;

use Auth;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Assignments\Entities\Gallery;
use Modules\Core\Traits\Livewire\WithValueMask;
use Modules\Employees\Entities\EmployeeReceipts;
use Modules\User\Entities\User;

class Add extends Component
{

    use WithFileUploads;
    use WithValueMask;

    public $photo;
    public $auth_user;
    public $user;
    public $amount;
    public $category;

    protected $fieldsMask = [
        'amount',
    ];

    public function mount(User $user)
    {

        $this->user = $user;
        $this->auth_user = Auth::user();
    }
    /*     public function updated($field)
    {
        $array = array('amount');

        if (in_array($field, $array)) {
            $this->{$field} = ($this->{$field} != '') ? number_format(preg_replace('/[^0-9.]+/', '', $this->{$field}), 2) : '';
        }
    } */

    public function save()
    {
        $amount = $this->clearValue($this->amount);


        $this->validate([
            'photo' => 'mimes:jpg,jpeg,png,pdf',
        ]);
        $imagedata = file_get_contents($this->photo->path());
        $base64 = base64_encode($imagedata);
        $b64 = 'data:image/jpeg;base64,' . $base64;

        EmployeeReceipts::create([
            'user_id' => $this->user->id,
            'b64' => $b64,
            'status' => 'pending',
            'amount' => $amount,
            'category' => $this->category,
            'created_by' => $this->auth_user->id,
        ])->save();

        $this->emit('backList');
    }

    public function render()
    {
        return view('employees::livewire.show.tabs.receipts.add');
    }
}
