<?php

namespace Modules\Dashboard\Http\Livewire\List;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Repositories\AssignmentRepository;

class NobodyWasHome extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;
    public $columns = ['Name','Job Type','Schedule','Status','Referral','Address','Street','City','State', 'Phone', 'Created by', 'Created At', 'Update By','Update At'];
    public $selectedColumns = [];
    public $selectedRows = 100;

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
        $list = AssignmentRepository::open([37])->search($searchAssignment)->get();

        $list=$list->sortBy('start_date')->sortBy('order_status');

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('dashboard::livewire.list.nobody_was_home', [
            'list' =>$list
        ]);

    }
}
