<?php

namespace Modules\Referrals\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReferralBilling extends Model
{
    use HasFactory;
    protected $table = 'referral_billing';
    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Referrals\Database\factories\ReferralBillingFactory::new();
    }
}
