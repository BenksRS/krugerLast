<?php

namespace Modules\Gdrive\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QueeFiles extends Model
{
    use HasFactory;
    protected $table    = 'quee_files';
    protected $fillable = [
        'assignment_id',
        'order',
        'status',
        'history'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Gdrive\Database\factories\QueeFilesFactory::new();
    }
}
