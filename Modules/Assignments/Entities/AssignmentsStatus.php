<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentsStatus extends Model
{
    use HasFactory;
    protected $table = 'assignments_status';
    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\AssignmentsStatusFactory::new();
    }
}
