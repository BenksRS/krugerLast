<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Rules;

use Livewire\Component;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Employees\Entities\EmployeeRules;
use Modules\Referrals\Entities\Referral;
use Modules\User\Entities\Techs;
use Modules\User\Entities\User;

class Add extends Component
{
    protected $listeners = [
        'contentChange' => 'processContent',
        'clearContent'

    ];

    public $user;
    public $ruleType;
    public $referral_id;
    public $carrier_id;
    public $jobTypes;
    public $techs;
    public $jobTypesSelected;
    public $techSelected;
    public $allReferrals;
    public $referralSelected;
    public $carrierSelected;

    public $showCarrierSelect = false;
    public $carrierLists;
    public $referral;

    public $date_start;
    public $date_end;
    public $valor;
    public $percentage;
    public $sq_min;
    public $sq_max;

    public $ref;


    protected $rules = [
        'type'
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->jobTypes = AssignmentsJobTypes::where('active','Y')->get();
        $this->techs = Techs::where('active','Y')->get();

        $this->allReferrals = Referral::all();
    }
    public function updated($field)
    {
        if ($field == 'referral_id') {


            $this->loadReferral();
            $this->emit('contentChange');
            $this->carrierSelected =  null;

        }
    }
    public function loadReferral(){
        $this->ref = Referral::find($this->referralSelected);
    }
    public function processContent(){
dd($this->referral_id);
        $this->carrierLists=[];
        $this->processCarrier($this->referralSelected);

    }
    public function processCarrier($id){
        $this->referral = Referral::find($id);
        $this->carrierLists = $this->referral->carriers;

        if(count($this->carrierLists) > 0){
            $this->showCarrierSelect = true;

        }else{
            $this->showCarrierSelect = false;

        }



    }
    public function addRule($formData){

        $formData=(object)$formData;

        $date_start = $valor =$tech_ids = $jobs_types = $sq_min = $sq_max = $referral_id = $endDate=null;
        $status='active';
        $valor = $percentage = 0;

        if(isset($formData->date_start)){
            $date_start =$formData->date_start;
        }
        if(isset($formData->carrier_id)){
            $carrier_id =  $formData->carrier_id;
        }
        if(isset($formData->valor)){
            $valor = $formData->valor;
        }
        if(isset($formData->techs_id)){
            $tech_ids = $formData->techs_id;
        }
        if(isset($formData->sq_min)){
            $sq_min = $formData->sq_min;
        }
        if(isset($formData->sq_max)){
            $sq_max = $formData->sq_max;
        }
        if(isset($formData->job_type)){
            $jobs_types = $formData->job_type;
        }
        if(isset($formData->percentage)){
            $perfixed=($formData->percentage > 0.05) ? 0.05 :$formData->percentage;

            $percentage= $perfixed;
        }
        if(isset($formData->referral_id)){
            $referral_id = $formData->referral_id;
        }
        if(isset($formData->date_end) && $formData->date_end != ''){
            $endDate=$formData->date_end;
            $status='disable';
        }
        $data = [
            'user_id' => $this->user->id,
            'start_date' => $date_start,
            'end_date' => $endDate,
            'referral_id' => $referral_id,
            'carrier_id' => $carrier_id,
            'tech_ids' => $tech_ids,
            'porcentagem' => $percentage,
            'dividir' => 1,
            'valor' => $valor,
            'type' => $formData->type,
            'status' => $status,
            'sq_min' => $sq_min,
            'sq_max' => $sq_max,
            'job_type' => $jobs_types,
        ];

        EmployeeRules::create($data)->save();


        $this->emit('toggleShowRules');

    }
    public function render()
    {
        return view('employees::livewire.show.tabs.rules.add');
    }
}
