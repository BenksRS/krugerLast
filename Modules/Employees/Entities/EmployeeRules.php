<?php

namespace Modules\Employees\Entities;

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
        'referral_id',
        'tech_ids',
        'porcentagem',
        'dividir',
        'status',
        'sq_min',
        'sq_max',
        'job_type'
    ];
    protected $appends = [
      'name'
    ];

    public function referral ()
    {
        return $this->belongsTo(Referral::class, 'referral_id', 'id');
    }
    public function showMoney($var){
        return number_format($var,2);
    }
    public function getNameAttribute ()
    {
      switch ($this->type){
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
              $referral=$this->referral->full_name;
              $info = "Marketing - %$p - $referral";
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
              $info = "Roof Tarp - $sq_min up to $sq_max sqft - $$valor";

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
