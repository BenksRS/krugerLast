<?php

namespace Modules\Employees\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeDoc extends Model
{
    use HasFactory;

    protected $table = 'employee_docs';

    protected $fillable = ['user_id', 'created_by', 'updated_by', 'type', 'path'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
