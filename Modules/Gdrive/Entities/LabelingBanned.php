<?php

namespace Modules\Gdrive\Entities;

use Illuminate\Database\Eloquent\Model;

class LabelingBanned extends Model
{
    protected $table = 'labeling_banned';

    protected $fillable = ['term', 'active', 'created_by'];

    protected $casts = ['active' => 'boolean'];
}
