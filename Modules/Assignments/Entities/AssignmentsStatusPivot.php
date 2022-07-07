<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class AssignmentsStatusPivot extends Model
{
    use HasFactory;
    protected $table = 'assignments_status_pivot';
    protected $fillable = [
        'assignment_id',
        'assignment_status_id',
        'created_by',
    ];

    protected $with=['status'];

    public function status()
    {
        return $this->belongsTo(AssignmentsStatus::class, 'assignment_status_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\AssignmentsStatusPivotFactory::new();
    }
}
