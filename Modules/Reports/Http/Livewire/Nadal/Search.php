<?php
	
	namespace Modules\Reports\Http\Livewire\Nadal;
	
	use Livewire\Component;
	use Modules\Assignments\Entities\AssignmentsJobTypes;
	use Modules\Employees\Entities\EmployeeCommissions;
	use Modules\Employees\Repositories\CommissionsRepository;
	use Modules\User\Entities\User;
	
	class Search extends Component {
		
		public    $status;
		
		public    $techs;
		
		public    $jobTypes;
		
		public    $loading  = FALSE;
		
		public    $filters  = [
			'user_id'  => NULL,
			'status'   => NULL,
			'job_type' => NULL,
			'dates'    => [
				'start' => NULL,
				'end'   => NULL
			]
		];
		
		protected $listData = [];
		
		public function mount()
		{
			$this->status   = ['pending' => 'Pending', 'available' => 'Available', 'paid' => 'Paid'];
			$this->techs    = User::where('active', 'Y')->where('group_id', 2)->get();
			$this->jobTypes = AssignmentsJobTypes::where('active', 'Y')->get();
			$this->listData = [];
		}
		
		protected function toCollection($data)
		{
			if (empty($data)) {
				return [];
			}
			
			$collection = $data->groupBy('user_id')->map(function($item, $key) {
				
				$item    = collect($item);
				$collect = collect();
				
				$commissions          = $item->groupBy('status')->map(fn ($item, $key) => $item->sum('amount'));
				$commissions['total'] = $commissions->sum();
				
				$collect['commissions'] = $commissions;
				$collect['assignments'] = $item;
				
				return $collect;
			});
			
			return $collection;
		}
		
		public function render()
		{
			
			$employeeCommissions = CommissionsRepository::whereIn('status', ['pending', 'available'])
			                                            ->whereDate('created_at', '>=', '2024-09-01')
			                                            ->whereNotNull('job_type');
			/*			->whereIn('assignment_id', [
							44703, 44709, 44710, 44716, 44717, 44778, 44713
						])*/
			
			$employeeCommissions = $employeeCommissions->get();
			
			$employeeCommissions = $this->toCollection($employeeCommissions);
			
			return view('reports::livewire.nadal.search', [
				'listData' => $employeeCommissions
			]);
		}
		
	}