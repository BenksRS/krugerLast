<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentsEvents extends Model
{
    use HasFactory;
    protected $table = 'assignments_events';
    protected $fillable = [
        'name',
        'active',
    ];

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\AssignmentsEventsFactory::new();
    }
}
