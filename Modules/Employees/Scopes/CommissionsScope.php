<?php
	
	namespace Modules\Employees\Scopes;
	
	use Illuminate\Database\Eloquent\Builder;
	
	trait CommissionsScope {
		
		public function scopeSearch(Builder $query, $search)
		{
			return $query->when($search, function(Builder $q, $search) {
				$q
					->where->searchUsers($search['user_id'])
					->where->searchStatus($search['status'])
					->where->searchJobType($search['job_type'])
					->where->searchDateCreated($search['dates']);
			});
		}
		
		public function scopeSearchUsers(Builder $query, $search)
		{
			return $query->when($search, function(Builder $q, $search) {
				$data = is_array($search) ? $search : [$search];
				$q->whereIn('user_id', $data);
			});
		}
		
		public function scopeSearchStatus(Builder $query, $search)
		{
			return $query->when($search, function(Builder $q, $search) {
				$data = is_array($search) ? $search : [$search];
				$q->whereIn('status', $data);
			});
		}
		
		public function scopeSearchJobType(Builder $query, $search)
		{
			return $query->when($search, function(Builder $q, $search) {
				$data = is_array($search) ? $search : [$search];
				$q->whereIn('job_type', $data);
			});
		}
		
		public function scopeSearchDateCreated(Builder $query, $search)
		{
			
			$date_from = $search['start'] ?? NULL;
			$date_to   = $search['end'] ?? NULL;
			
			return $query
				->when($date_from, function(Builder $q, $date_from) {
					$q->whereDate('created_at', '>=', $date_from);
				})
				->when($date_to, function(Builder $q, $date_to) {
					$q->whereDate('created_at', '<=', $date_to);
				});
		}
		
	}