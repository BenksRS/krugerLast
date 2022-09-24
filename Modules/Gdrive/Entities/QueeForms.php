<?php

namespace Modules\Gdrive\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QueeForms extends Model
{
    use HasFactory;
    protected $table    = 'quee_forms';
    protected $fillable = [
        'assignment_id',
        'order',
        'status',
        'type',
        'history'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Gdrive\Database\factories\QueeFormsFactory::new();
    }
}
