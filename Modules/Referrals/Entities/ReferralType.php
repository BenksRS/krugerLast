<?php

namespace Modules\Referrals\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReferralType extends Model
{
    use HasFactory;
    protected $table = 'referral_types';
    protected $fillable = [
        'name',
        'active'
    ];

    public function referrals()
    {
        return $this->hasMany(Referral::class,'referral_type_id','id');
    }

    protected static function newFactory()
    {
        return \Modules\Referrals\Database\factories\ReferralTypesFactory::new();
    }
}
