<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentsEventPivot extends Model
{
    use HasFactory;

    protected $table = 'assignments_event_pivot';
    protected $fillable = [];
    protected $with=['event'];
    public function event()
    {
        return $this->belongsTo(AssignmentsEvents::class, 'event_id', 'id');
    }
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\AssignmentsEventPivotFactory::new();
    }
}
