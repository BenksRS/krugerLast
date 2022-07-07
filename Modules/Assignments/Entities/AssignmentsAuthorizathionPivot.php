<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentsAuthorizathionPivot extends Model
{
    use HasFactory;

    protected $table = 'assignments_authorization_pivot';
    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\AssignmentsAuthorizathionPivotFactory::new();
    }
}
