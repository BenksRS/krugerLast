<?php

namespace Modules\Referrals\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ReferralsScope
{
    public function scopeAuths (Builder $query, $carrier_id = 11)
    {
        return $query
            ->whereHas('authorizathions.carrier_id', function (Builder $query) use ($carrier_id) {
                $query->whereIn('id', collect($carrier_id))->whereNotNull('id');
            });
    }
}
