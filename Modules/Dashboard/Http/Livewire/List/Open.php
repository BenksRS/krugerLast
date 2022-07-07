<?php

namespace Modules\Dashboard\Http\Livewire\List;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Repositories\AssignmentRepository;

class Open extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;
    public $columns = ['Name','Job Type','Schedule','Status','Referral','Address','Street','City','State', 'Phone', 'Created by', 'Created At', 'Update By','Update At'];
    public $selectedColumns = [];
    public $selectedRows = 10;

    public function mount()
    {
        $this->selectedColumns = $this->columns;

    }
    public function updatingSearchAssignment()
    {
        $this->resetPage();
    }
    public function render()
    {
        $searchAssignment = $this->searchAssignment;
        $list = AssignmentRepository::open()->search($searchAssignment)->get();

//        $list = Assignment::with(['scheduling','referral','carrier','status','event','phones','user_updated','user_created','job_types'])->whereIn('status_id',[1,2,3,4,8,11,12,14,15,17,18,19,20,21,22,23])->get();


        $list=$list->sortBy('start_date')->sortBy('order_status');

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('dashboard::livewire.list.open', [
            'list' =>$list
        ]);

    }
}
