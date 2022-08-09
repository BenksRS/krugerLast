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

    public function referral ()
    {
        return $this->belongsTo(Referral::class, 'referral_id', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\Employees\Database\factories\EmployeeRulesFactory::new();
    }
}
