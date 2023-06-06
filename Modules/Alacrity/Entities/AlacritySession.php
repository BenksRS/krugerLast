<?php

namespace Modules\Alacrity\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlacritySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_session_id',
        'expires_at',
    ];


    protected static function newFactory()
    {
        return \Modules\Alacrity\Database\factories\AlacritySessionFactory::new();
    }
}
