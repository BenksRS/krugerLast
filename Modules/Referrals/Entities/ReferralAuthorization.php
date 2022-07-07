<?php

namespace Modules\Referrals\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReferralAuthorization extends Model
{
    use HasFactory;

    protected $table = 'referral_authorizations';
    protected $fillable = [
        'description',
        'name'
    ];
//    protected $with = ['referrals'];


//    public function referrals()
//    {
//        return $this->belongsToMany(Referral::class,'referral_authorization_pivots','referral_authorizathion_id','referral_id','id');
//    }
    protected static function newFactory()
    {
        return \Modules\Referrals\Database\factories\ReferralAuthorizationsFactory::new();
    }
}
