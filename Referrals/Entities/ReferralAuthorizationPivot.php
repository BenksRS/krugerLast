<?php

namespace Modules\Referrals\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralAuthorizationPivot extends Model
{
    use HasFactory;
    protected $table = 'referral_authorization_pivots';
    protected $fillable = [
        'referral_id',
        'carrier_id',
        'referral_authorizathion_id'
    ];

/*    public function created()
    {
        return $this->created_at;
    }*/
    protected static function newFactory()
    {
        return \Modules\Referrals\Database\factories\ReferralAuthorizationPivotFactory::new();
    }
}
