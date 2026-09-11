<?php

namespace Modules\Gdrive\Entities;

use Illuminate\Database\Eloquent\Model;

class QueeLabeling extends Model
{
    protected $table = 'quee_labeling';

    protected $fillable = [
        'assignment_id',
        'order',
        'status',
        'batch_id',
        'payload',
        'history',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
