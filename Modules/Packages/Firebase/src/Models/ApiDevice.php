<?php

namespace Callkruger\Api\Models;

use Illuminate\Database\Eloquent\Model;

class ApiDevice extends Model {


    protected $fillable = ['token', 'properties'];

    public function connections ()
    {
        return $this->hasMany(ApiConnection::class, 'device_id', 'id');
    }

}
