<?php

namespace Modules\Gdrive\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QueeDir extends Model
{
    use HasFactory;
    protected $table    = 'quee_dir';

    protected $fillable = [
        'assignment_id',
        'order',
        'status',
        'history'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Gdrive\Database\factories\QueeDirFactory::new();
    }
}
