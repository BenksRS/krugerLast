<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Techs extends Model
{
    use HasFactory;
    protected $table = 'techs';
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    protected static function newFactory()
    {
        return \Modules\User\Database\factories\TechsFactory::new();
    }
}
