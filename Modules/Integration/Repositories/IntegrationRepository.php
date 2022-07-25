<?php

namespace Modules\Integration\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\Integration\Entities\Integration;

trait IntegrationRepository {

    public function sync ()
    {
        return $this->morphOne(Integration::class, 'syncable');
    }

    public function scopeNotSynced (Builder $query)
    {
        return $query->doesntHave('sync');
    }

}