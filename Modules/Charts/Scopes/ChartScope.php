<?php

namespace Modules\Charts\Scopes;

trait ChartScope {

    public function scopeDateRange ( $query, $start, $end, $column = 'created_at' )
    {
        return $query->whereDate($column, '>=', $start)->whereDate($column, '<=', $end);
    }

}