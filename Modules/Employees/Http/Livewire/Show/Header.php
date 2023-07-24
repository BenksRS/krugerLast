<?php

namespace Modules\Employees\Http\Livewire\Show;

use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Manny\Manny;
use Modules\Employees\Entities\EmployeeInfo;
use Modules\User\Entities\User;


class Header extends Component
{
    public $show = true;
    public $user;
    public $user_info;
    public $active;
    public $name;
    public $url;

    public $full_name;
    public $phone;
    public $phone_edit;
    public $dob;
    public $start_date;
    public $group_selected;





    protected $rules = [
        'name' => 'required',
        'active' => 'required',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->check_user_info($this->user->id);

        $this->full_name = $this->user_info->full_name;
        $this->phone = $this->user_info->phone;
        $this->dob = $this->user_info->dob;
        $this->start_date = $this->user_info->start_date;


        $this->active = $user->active;

        $this->url = \session()->get('url');

    }

    public function updated($field)
    {
        if ($field == 'phone')
        {
            $this->phone = Manny::mask($this->phone, "(111) 111-1111");
        }
        if ($field == 'phone_edit')
        {
            $this->phone_edit = Manny::mask($this->phone_edit, "(111) 111-1111");
        }
    }

    public function check_user_info($user_id){

        $user_info=EmployeeInfo::where('user_id',$user_id)->first();

        if($user_info){
            $this->user_info=$user_info;
        }else{
            EmployeeInfo::create([
                'user_id' => $user_id
            ])->save();

            $user_info=EmployeeInfo::where('user_id',$user_id)->first();
            $this->user_info=$user_info;
        }

    }
    public function edit(){

        $this->show = false;
    }
    public function update($formData){
        $this->validate();
        $formData=(object)$formData;
        $errors = $this->getErrorBag();

        $user_update=[
            'name'=>$formData->name,
            'active'=>$formData->active
        ];

        $update = $this->user->update($user_update);
        $id=$this->user->id;
        $this->user = User::find($id);

        ## Update Info


        $update_user_info=[
            'full_name'=>$this->full_name,
            'phone'=>$this->phone,
            'dob'=>$this->dob,
            'start_date'=>$this->start_date
        ];
        $update_info = $this->user_info->update($update_user_info);

        $this->user_info = EmployeeInfo::find($this->user_info->id);



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
