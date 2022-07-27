<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Signdata extends Model {

    use HasFactory;

    protected $table    = 'signdata';

    protected $fillable = [
        'assignment_id',
        'created_by',
        'b64',
        'type',
        'preferred',
        'date_sign',
    ];

    protected static function newFactory ()
    {
        return \Modules\Assignments\Database\factories\SigndataFactory::new();
    }

}
