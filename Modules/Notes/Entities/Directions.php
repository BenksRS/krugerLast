<?php

namespace Modules\Notes\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Directions extends Model
{
    use HasFactory;
    protected $table = 'directions';
    protected $fillable = [
        'origin',
        'destination',
        'text',
        'value'
    ];

    
    protected static function newFactory()
    {
        return \Modules\Notes\Database\factories\DirectionsFactory::new();
    }
}
