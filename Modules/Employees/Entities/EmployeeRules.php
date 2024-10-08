<?php

namespace Modules\Employees\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Referrals\Entities\Referral;

class EmployeeRules extends Model
{
    use HasFactory;
    protected $table    = 'employee_rules';
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'referral_id',
        'carrier_id',
        'state',
        'tech_ids',
        'porcentagem',
        'dividir',
        'valor',
        'type',
        'status',
        'sq_min',
        'sq_max',
        'job_type'
    ];
    protected $appends = [
      'name',
        'start_date_view',
        'end_date_view',
        'type_name'

    ];

    public function referral ()
    {
        return $this->belongsTo(Referral::class, 'referral_id', 'id');
    }
    public function carrier ()
    {
        return $this->belongsTo(Referral::class, 'carrier_id', 'id');
    }
    public function getStartDateViewAttribute(){

        $return = "-";
        if($this->start_date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('m/d/Y');
        }
        return $return;
    }
    public function getEndDateViewAttribute(){

        $return = "-";
        if($this->end_date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date)->format('m/d/Y');
        }
        return $return;
    }

    public function showMoney($var){
        return number_format($var,2);
    }
    public function getTypeNameAttribute (){
        switch ($this->type){
            case 'T':
                $info = "Technician";
                break;
            case 'A':
                $info = "Technician TREE REMOVAL";
                break;
            case 'N':
                $info = "Technician NO TREE";
                break;
            case 'R':
                $info = "Marketing Referral Full";
                break;
            case 'X':
                $info = "Marketing Referral by State";
                break;
            case 'C':
                $info = "Marketing Carrier from Referral";
                break;
            case 'Z':
                $info = "Marketing Carrier from Referral by state";
                break;
            case 'J':
                $info = "Job Type";
                break;
            case 'S':
                $info = "Roof Tarp";
                break;
            case 'P':
                $info = "All Jobs";
                break;
        }
        return $info;
    }
    public function getNameAttribute ()
    {
      switch ($this->type){
          case 'A':
              $p=$this->porcentagem*100;
              $explode=explode(',',$this->tech_ids);
              $tech="";
              foreach ($explode as $o){
                  $info=\Modules\User\Entities\User::find($o);
                  $tech="$tech / $info->name";

              }
              $info = "Technician TREE REMOVAL- %$p $tech";
              break;
          case 'N':
              $p=$this->porcentagem*100;
              $explode=explode(',',$this->tech_ids);
              $tech="";
              foreach ($explode as $o){
                  $info=\Modules\User\Entities\User::find($o);
                  $tech="$tech / $info->name";

              }
              $info = "Technician NO TREE- %$p $tech";
              break;
          case 'T':
              $p=$this->porcentagem*100;
              $explode=explode(',',$this->tech_ids);
              $tech="";
              foreach ($explode as $o){
                  $info=\Modules\User\Entities\User::find($o);
                  $tech="$tech / $info->name";

              }
              $info = "Technician - %$p $tech";
              break;
          case 'R':
              $p=$this->porcentagem*100;
              $referral=$this->referral->company_entity;

              $info = "Marketing Referral Full - %$p - $referral #$this->referral_id";
              break;
          case 'X':
              $p=$this->porcentagem*100;
              $referral=$this->referral->company_entity;
              $state=$this->state;

              $info = "Marketing Referral Full by State - $state - %$p - $referral #$this->referral_id";
              break;
          case 'C':
              $p=$this->porcentagem*100;
              $referral=$this->referral->company_entity;
              $carrier=$this->carrier->company_entity;

              $info = "Marketing Carrier from Referral - %$p - $referral #$this->referral_id ==> $carrier #$this->carrier_id";
              break;
          case 'Z':
              $p=$this->porcentagem*100;
              $referral=$this->referral->company_entity;
              $carrier=$this->carrier->company_entity;
              $state=$this->state;

              $info = "Marketing Carrier from Referral - $state - %$p - $referral #$this->referral_id ==> $carrier #$this->carrier_id";
              break;
          case 'J':
              $job_type=\Modules\Assignments\Entities\AssignmentsJobTypes::find($this->job_type);
              $valor=$this->showMoney($this->valor);
              $info = "$job_type->name - $$valor";
              break;
          case 'S':
              $sq_min=(int)$this->sq_min;
              $sq_max=(int)$this->sq_max;
              $valor=$this->showMoney($this->valor);
              $info = "Roof Tarp -  $sq_min.ft up to $sq_max.ft - $$valor";

              break;
          case 'P':
              $p=$this->porcentagem*100;
              $info = "All Jobs - %$p";
              break;
      }
        return $info;
    }
    protected static function newFactory()
    {
        return \Modules\Employees\Database\factories\EmployeeRulesFactory::new();
    }
}
