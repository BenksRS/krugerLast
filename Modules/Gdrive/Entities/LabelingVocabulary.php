<?php

namespace Modules\Gdrive\Entities;

use Illuminate\Database\Eloquent\Model;

class LabelingVocabulary extends Model
{
    protected $table = 'labeling_vocabulary';

    protected $fillable = ['category', 'term', 'active', 'sort', 'created_by'];

    protected $casts = ['active' => 'boolean'];
}
