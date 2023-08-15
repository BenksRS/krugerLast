<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs;

use Livewire\Component;
use Modules\Employees\Entities\EmployeeInfo;
use Modules\User\Entities\User;

class Docs extends Component
{

    public $user;

    public $docs = [];

    public $non_compete;
    public $drive_license;
    public $work_permit;
    public $bank_account;
    public $payroll_forms;
    public $background_auth;
    public $vcc;
    public $medical_card;
    public $drug_test;
    public $insurance;

    public $user_info;

    public $options_chek=['non_compete','drive_license','work_permit','bank_account','payroll_forms','background_auth','vcc','medical_card','insurance', 'drug_test'];

    public function mount(User $user)
    {


        $this->user = $user;
        $this->user_info=EmployeeInfo::where('user_id',$this->user->id)->first();

        $this->non_compete =$this->user_info->non_compete;
        $this->drive_license =$this->user_info->drive_license;
        $this->work_permit =$this->user_info->work_permit;
        $this->bank_account =$this->user_info->bank_account;
        $this->payroll_forms =$this->user_info->payroll_forms;
        $this->background_auth =$this->user_info->background_auth;
        $this->vcc =$this->user_info->vcc;
        $this->drug_test =$this->user_info->drug_test;
        $this->medical_card =$this->user_info->medical_card;
        $this->insurance =$this->user_info->insurance;

        $this->docs = config('employees.docs');
    }

    public function updateAll(){

        $update_info=[
            'non_compete'=> $this->non_compete,
            'drive_license'=> $this->drive_license,
            'work_permit'=> $this->work_permit,
            'bank_account'=> $this->bank_account,
            'payroll_forms'=> $this->payroll_forms,
            'background_auth'=> $this->background_auth,
            'drug_test'=> $this->drug_test,
            'medical_card'=> $this->medical_card,
            'insurance'=> $this->insurance,
            'vcc'=> $this->vcc
        ];
        $update =  $this->user_info->update($update_info);


        $this->user_info=EmployeeInfo::where('user_id',$this->user->id)->first();
    }
    public function render()
    {
        return view('employees::livewire.show.tabs.docs');
    }
}
