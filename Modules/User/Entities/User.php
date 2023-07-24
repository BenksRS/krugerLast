<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsEvents;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Employees\Entities\EmployeeInfo;
use Modules\Employees\Entities\EmployeeRate;

class User extends Authenticatable {

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'active',
        'password',
        'group_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*	protected $appends = ['selected'];*/

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts   = [
        'email_verified_at' => 'datetime',
        'superadmin'        => 'boolean',
    ];

    protected $appends = [];

    public function setPasswordAttribute ($value)
    {
        $this->attributes["password"] = Hash::make($value);
    }


    public function getSelectedAttribute ()
    {
        return ['Michel' => 'Michel', 'Vieira' => 'Vieira'];
    }

    public function assignment ()
    {
        return $this->belongsTo(Assignment::class, 'id', 'created_by');
    }

    public function group ()
    {
        return $this->belongsTo(UserGroup::class, 'group_id');
    }
    public function info ()
    {
        return $this->belongsTo(EmployeeInfo::class, 'id','user_id');
    }

}
