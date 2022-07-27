<?php

namespace Modules\Integration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IntegrationFailedJob extends Model {

    use HasFactory;

    protected $fillable = ['queue', 'payload', 'exception', 'failed_at'];

    protected $casts    = [
        'payload' => 'json',
    ];

    public function setFailedAtAttribute ($value)
    {
        $this->attributes["failed_at"] = now();
    }

}
