<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_groups';
    protected $fillable = ['name', 'active'];


}
