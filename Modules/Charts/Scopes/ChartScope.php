<?php

namespace Modules\Charts\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

trait ChartScope {

	/**
	 * @param Builder $query
	 * @param         $start
	 * @param         $end
	 * @param         $column
	 *
	 * @return Builder
	 */
	public function scopeDateRange ( Builder $query, $start, $end, $column = 'created_at' )
	{
		return $query->whereDate($column, '>=', Carbon::parse($start)->format('Y-m-d'))->whereDate($column, '<=', Carbon::parse($end)->format('Y-m-d'));
	}

	public function scopeGroupByReferral ( Builder $query, $column = 'referral_id' )
	{
		return $query->with(['referral.type', 'carrier'])->selectRaw('referral_id, count(*) as total')->groupBy('referral_id');
	}

}