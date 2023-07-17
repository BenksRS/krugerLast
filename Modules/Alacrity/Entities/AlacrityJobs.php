<?php

namespace Modules\Alacrity\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlacrityJobs extends Model
{
    use HasFactory;
    protected $table    = 'alacrity_jobs';
    protected $fillable = [
        'alacrity_id',
        'assignment_id',
        'order',
        'status',
        'acepted',
        'history'

    ];
    
    protected static function newFactory()
    {
        return \Modules\Alacrity\Database\factories\AlacrityJobsFactory::new();
    }
}
