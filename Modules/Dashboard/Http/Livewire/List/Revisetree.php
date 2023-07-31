<?php

namespace Modules\Dashboard\Http\Livewire\List;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Assignments\Repositories\AssignmentRepository;

class Revisetree extends Component
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
        $list = AssignmentFinanceRepository::revisetree()->search($searchAssignment)->where('created_at', '>', '2023-01-01 00:00:07')->get();


        $list=$list->sortByDesc('id');

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('dashboard::livewire.list.revisetree',[
            'list' =>$list
        ]);
    }

}
