<?php

namespace Modules\Integration\Entities;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{

    protected $fillable = ['uuid', 'syncable_type', 'syncable_id'];
    

    /**
     * Get the parent imageable model (user or post).
     */
    public function syncable ()
    {
        return $this->morphTo(__FUNCTION__, 'syncable_type', 'syncable_id');
    }
}
