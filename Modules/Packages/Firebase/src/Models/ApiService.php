<?php

namespace Callkruger\Api\Models;

use Illuminate\Database\Eloquent\Model;

class ApiService extends Model {


    protected $fillable = ['driver', 'data_key', 'syncable_type', 'syncable_id', 'status'];

    /**
     * Get the parent imageable model (user or post).
     */
    public function syncable ()
    {
        return $this->morphTo();
    }

}
