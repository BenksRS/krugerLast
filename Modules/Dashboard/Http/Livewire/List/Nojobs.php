<?php
	
	namespace Modules\Dashboard\Http\Livewire\List;
	
	use Illuminate\Pagination\LengthAwarePaginator;
	use Livewire\Component;
	use Livewire\WithPagination;
	use Modules\Assignments\Repositories\AssignmentRepository;
	use Modules\Notes\Entities\Note;
	
	class Nojobs extends Component {
		
		use WithPagination;
		
		protected $paginationTheme = 'bootstrap';
		
		public    $searchAssignment;
		
		public    $columns         = [
			'Name', 'Job Type', 'Schedule', 'Status', 'Referral', 'Address', 'Street', 'City', 'State', 'Phone',
			'Claim Number', 'NoJob Info', 'Created by', 'Created At', 'Update By', 'Update At'
		];
		
		public    $selectedColumns = [];
		
		public    $selectedRows    = 100;
		
		public function mount()
		{
			$this->selectedColumns = $this->columns;
		}
		
		public function updatingSearchAssignment()
		{
			$this->resetPage();
		}
		
		protected function getNoJobInfo($items)
		{
			$ids = $items->pluck('id');
			$notes = Note::whereIn('notable_id', $ids)->where('notable_type', 'Modules\Assignments\Entities\Assignment')
			             ->where('type', 'no_job')->get();
			
			return $items->map(function($item) use ($notes) {
				$item->nojob_info = $notes->where('notable_id', $item->id)->first();
				
				return $item;
			});
		}
		
		public function render()
		{
			$searchAssignment = $this->searchAssignment;
			$list             = AssignmentRepository::Nojobs()->search($searchAssignment)->get();
			
			$list = $list->sortBy('start_date')->sortBy('order_status');
			
			$items = $list->forPage($this->page, $this->selectedRows);
			
			$items = $this->getNoJobInfo($items);
			
			$list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);
			
			return view('dashboard::livewire.list.nojobs', [
				'list' => $list
			]);
		}
		
	}
