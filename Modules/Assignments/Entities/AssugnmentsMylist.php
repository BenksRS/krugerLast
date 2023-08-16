<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssugnmentsMylist extends Model
{
    use HasFactory;
    protected $table='assignments_mylist';
    protected $fillable = [
        'assignment_id',
        'user_id',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\AssugnmentsMylistFactory::new();
    }
}
