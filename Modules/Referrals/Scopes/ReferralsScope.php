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
    public function scopeSearchtopref (Builder $query, $search, $marketing){
        return $query
            ->whereIn('marketing_id', collect($marketing))->whereNotNull('id')
            ->when($search, function ($query, $search) {
                $query
                    ->where('company_entity', 'like', '%' .$search . '%')
                    ->orWhere('company_fictitions', 'like', '%' .$search . '%')
//                    ->orWhere('type.name', 'like', '%' .$search . '%')
                    ->orWhere('id', $search);
            });
    }
}
