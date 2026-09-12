<?php

namespace Modules\Teams\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Workers;

class Team extends Model {

    protected $table    = 'teams';

    protected $fillable = [
        'name',
    ];

    public function workers()
    {
        return $this->hasMany(Workers::class, 'team_id', 'id');
    }

}