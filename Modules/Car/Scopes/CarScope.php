<?php

namespace Modules\Car\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait CarScope
{
    public function scopeSearchtop (Builder $query, $search)
    {
        return $query
            ->when($search, function ($query, $search) {
                $query
                    ->where('auto', 'like', '%' . $search . '%')
                    ->orWhere('driver', 'like', '%' . $search . '%')
                    ->orWhere('make', 'like', '%' . $search . '%')
                    ->orWhere('year', 'like', '%' . $search . '%')
                    ->orWhere('plate', 'like', '%' . $search . '%')
                    ->orWhere('epass', 'like', '%' . $search . '%')
                    ->orWhere('vin', 'like', '%' . $search . '%');

            });
    }
}
