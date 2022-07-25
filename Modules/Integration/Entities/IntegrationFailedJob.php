<?php

namespace Modules\Integration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IntegrationFailedJob extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Integration\Database\factories\IntegrationFailedJobFactory::new();
    }
}
