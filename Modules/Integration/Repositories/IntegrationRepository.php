<?php

namespace Modules\Integration\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
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

    public function setData ()
    {
        return [];
    }

    public function getData ()
    {
        return [];
    }

    protected function checkEncoder ($file = NULL)
    {
        $encoder = 'data:image/jpeg;base64,/';

        return (string) Str::of($file)->trim(',/')->start($encoder);
    }

}