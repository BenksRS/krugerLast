<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentsTagsPivot extends Model
{
    use HasFactory;
    protected $table='assignments_tags_pivot';
    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\AssignmentsTagsPivotFactory::new();
    }
}
