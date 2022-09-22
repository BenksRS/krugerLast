<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Docsign extends Model
{
    use HasFactory;
    protected $table='docsign';

    protected $fillable = [
        'b64',
        'assignment_id',
        'name',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\DocsignFactory::new();
    }
}
