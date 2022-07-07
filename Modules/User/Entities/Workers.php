<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workers extends Model
{
    use HasFactory;
    protected $table = 'workers';
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    protected static function newFactory()
    {
        return \Modules\User\Database\factories\WorkersFactory::new();
    }
}
