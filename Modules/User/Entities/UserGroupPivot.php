<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserGroupPivot extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_group_pivot';
    protected $fillable = ['user_id', 'user_group_id', 'superadmin'];

}
