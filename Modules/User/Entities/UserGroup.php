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
    protected $fillable = ['name', 'active'];

    public function users ()
    {
        return $this->belongsToMany(User::class);
    }
}
