<?php

namespace Modules\Referrals\Http\Livewire\Show\Tabs\Auths;

use Livewire\Component;

use Modules\Referrals\Entities\FieldAuthorizations;
use Modules\Referrals\Entities\ReferralAuthorization;

class AuthEdit extends Component
{

    protected $listeners = [
        'reloadIframe',
        'saveCustom',
        'editAuth'
    ];

    public $showEditAuth=false;
    public $url_pdf;
    public $auth;
    public $auth_name_new;
    public $auth_description;
    public $authorization;
    public $auth_name;
    public $auth_id;
    public $field_authorizations;
    public $field_authorizationsActive=[];
    public $fieldsOpen=[];
    public $customFields=[];


    public $validFields=['address','carrier','city','city_state_zipcode','claim_number','date_sign','dol','full_name','job_type','KRUGER','month_sign','sign','single_year_sign','state','x','year_sign','zipcode'];


    public function mount($auth_id, $showEditAuth = false){
        $this->auth_id = $auth_id;
        $this->auth = ReferralAuthorization::find($auth_id);

        if(  $this->auth){
            $this->auth_description = $this->auth->description;
            $this->auth_name_new = $this->auth->name;
        }
        $this->url_pdf = url("assignments/pdfauth/27870/$this->auth_id");

        if($showEditAuth){
            $this->showEditAuth = $showEditAuth;
        }

        $this->refreshCustomfields();
    }
    public function updateName(){
        foreach($this->customFields as $key => $item){

            $update['description']=$this->auth_description;
            $update['name']=$this->auth_name_new;

            $this->auth->update($update);
        }
    }
    public function back(){
        $this->showEditAuth = !$this->showEditAuth;
    }
    public function editAuth($auth_id){
        $this->auth_id = $auth_id;

        $this->showEditAuth = !$this->showEditAuth;

    }
    public function updated($field)
    {
        if (str_contains($field, 'customFields')){
            $this->saveCustom();
        }
    }
    public function addField($field){
        FieldAuthorizations::create([
           'referral_authorizathion_id'=>$this->auth_id,
           'height'=>10,
           'length'=>10,
           'field'=>$field,
        ])->save();
        sleep(0.9);
        $this->refreshCustomfields();
    }
    public function removeField($id){
        $deletesCustomField = FieldAuthorizations::find($id);
        $deletesCustomField->delete();

        $this->refreshCustomfields();
    }

    public function saveCustom()
    {
        foreach ($this->customFields as $key => $item) {

            if (empty($item['length']) || empty($item['height'])) {
                continue;
            }

            $field_update = FieldAuthorizations::find($key);

            // Só atualiza se encontrar o registro (evita erro se id inválido)
            if ($field_update) {
                $update['length'] = $item['length'];
                $update['height'] = $item['height'];
                $field_update->update($update);
            }
        }

        $this->refreshCustomfields();
    }
    public function refreshCustomfields(){
        $this->authorization = ReferralAuthorization::find($this->auth_id);
        $this->field_authorizations = FieldAuthorizations::where('referral_authorizathion_id', $this->auth_id)->get();
        $time=date('Y-m-d H:i:s');
        $this->url_pdf = url("assignments/pdfauth/27870/$this->auth_id?time=$time");


        foreach ($this->field_authorizations as $item) {

            $this->customFields[$item->id]=[
                "length" => $item->length,
                "height" => $item->height,
            ];

        }
        $this->field_authorizationsActive = $this->field_authorizations->pluck('field')->toArray();
        $this->fieldsOpen=array_diff($this->validFields, $this->field_authorizationsActive);
    }
    public function render()
    {
        $this->refreshCustomfields();
        return view('referrals::livewire.show.tabs.auths.auth-edit');
    }
}