<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Info;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;

class Address extends Component
{

    public $show = true;
    public $assignment;
    // fields
    public $street;
    public $city;
    public $state;
    public $zipcode;
    public $email;
    public $address_link;
    public $address_target;
    public $address_message;

    protected $rules = [
        'street' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zipcode' => 'required',
        'email' => 'email',
    ];

    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->street = $assignment->street;
        $this->city = $assignment->city;
        $this->state = $assignment->state;
        $this->zipcode = $assignment->zipcode;
        $this->email = $assignment->email;
        $this->address_link = $assignment->address->link;
        $this->address_target = $assignment->address->target;
        $this->address_message = $assignment->address->message;
    }
    public function clean($str){
        $result = str_replace(array("`#`", "'"), '', $str);
        return $result;
    }
    public function edit(){

        $this->show = false;

    }
    public function update($formData){
        $this->validate();

        $errors = $this->getErrorBag();

        $id =  $this->assignment->id;
        $update = $this->assignment->update($formData);

        $this->assignment = Assignment::find($id);
        session()->flash('alert' ,[
            'class' => 'success',
            'message' => "Address/E-mail successfully updated.."
        ]);
        $this->address_link = $this->assignment->address->link;
        $this->address_target = $this->assignment->address->target;
        $this->address_message = $this->assignment->address->message;

        if(in_array($this->assignment->status_id, [2,3])){
            integration('assignments')->set($this->assignment->id);
        }

        $this->show = true;

    }

    public function render()
    {
        return view('assignments::livewire.show.tabs.info.address');
    }
}
