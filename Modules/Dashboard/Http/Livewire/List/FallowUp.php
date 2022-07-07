<?php

namespace Modules\Dashboard\Http\Livewire\List;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;

class FallowUp extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;
    public $columns = ['Billed Date','Status Collection','Name','Invoices', 'Status','follow_up','days_from_billing','days_from_service', 'Referral','City','State', 'Phone'];
    public $selectedColumns = [];
    public $selectedRows = 10;

    public $total_collection;

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
        $today=Carbon::now();
        $list = AssignmentFinanceRepository::collection()->whereDate('follow_up', '<=',$today)->search($searchAssignment)->get();

        $total_collection=$list->sum('finance.invoices.total');
        $this->total_collection = number_format($total_collection, 2);

        $list=$list->sortBy('follow_up');

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('dashboard::livewire.list.fallow-up',[
            'list' =>$list
        ]);
    }

}
