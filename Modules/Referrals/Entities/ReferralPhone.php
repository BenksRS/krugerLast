<?php

namespace Modules\Referrals\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReferralPhone extends Model
{
    use HasFactory;
    protected $table = 'referral_phones';
    protected $fillable = [
        'referral_id',
        'contact',
        'phone',
        'preferred'
        ];


//    public function phones()
//    {
//        return $this->hasMany( Referral::class, 'referral_id','id');
//    }

    protected static function newFactory()
    {
        return \Modules\Referrals\Database\factories\ReferralPhoneFactory::new();
    }
}
