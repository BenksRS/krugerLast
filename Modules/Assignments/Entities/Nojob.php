<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nojob extends Model
{
    use HasFactory;

    protected $table = 'nobjob';

    protected $fillable = [
        ''
    ];
    
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\NojobFactory::new();
    }
}
