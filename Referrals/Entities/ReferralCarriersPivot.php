<?php

namespace Modules\Referrals\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReferralCarriersPivot extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_vendor_id',
        'referral_carrier_id',
        'auth',
        'default',
    ];
    protected $table = 'referral_carriers_pivots';
//    public function referral()
//    {
//        return $this->belongsToMany(Referral::class,'referral_vendor_id','id');
//    }
//    public function carrier()
//    {
//        return $this->belongsTo(Referral::class,'referral_carrier_id','id');
//    }
    protected static function newFactory()
    {
        return \Modules\Referrals\Database\factories\ReferralCarriersPivotFactory::new();
    }
}
