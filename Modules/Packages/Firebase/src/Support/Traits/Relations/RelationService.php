<?php

namespace Callkruger\Api\Support\Traits\Relations;

use Callkruger\Api\Models\ApiService;
use Illuminate\Database\Eloquent\Builder;

trait RelationService {

    public function sync ()
    {
        return $this->morphOne(ApiService::class, 'syncable');
    }

    public function scopeNotSynced(Builder $query)
    {
        return $query->doesntHave('sync');
    }

}
