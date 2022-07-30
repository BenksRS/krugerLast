<?php

namespace Modules\Referrals\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FieldAuthorizations extends Model
{
    use HasFactory;
    protected $table = 'field_authorizations';
    protected $fillable = [
        'referral_authorizathion_id',
        'height',
        'length',
        'field',
    ];

    protected static function newFactory()
    {
        return \Modules\Referrals\Database\factories\FieldAuthorizationsFactory::new();
    }
}
