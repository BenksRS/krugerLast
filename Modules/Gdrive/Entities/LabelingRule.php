<?php

namespace Modules\Gdrive\Entities;

use Illuminate\Database\Eloquent\Model;

class LabelingRule extends Model
{
    protected $table = 'labeling_rules';

    protected $fillable = ['section', 'body', 'active', 'sort', 'created_by'];

    protected $casts = ['active' => 'boolean'];
}
