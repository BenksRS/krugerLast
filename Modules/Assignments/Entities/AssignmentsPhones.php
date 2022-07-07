<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentsPhones extends Model
{
    use HasFactory;
    protected $table = 'assignments_phones';
    protected $fillable = [
        'assignment_id',
        'contact',
        'phone',
        'preferred'
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\AssignmentsPhonesFactory::new();
    }
}
