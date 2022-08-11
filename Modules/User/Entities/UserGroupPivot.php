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
    protected $fillable = ['user_id', 'user_group_id', 'superadmin'];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}
