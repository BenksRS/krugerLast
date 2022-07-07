<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentsStatusCollection extends Model
{
    use HasFactory;
    protected $table = 'assignments_status_collection';

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\AssignmentsStatusCollectionFactory::new();
    }
}
