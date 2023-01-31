<?php

namespace Modules\Assignments\Http\Livewire\List;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentFinance;

class ListAll extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;
//    public $columns = ['Name','Job Type','Schedule','Status','Address','Street','City','State', 'Phone', 'Invoice', 'Created by', 'Created At'];
    public $columns = ['Name','Job Type','Schedule','Status','Referral','Address','Street','City','State', 'Phone', 'Invoice', 'Created by', 'Created At', 'Update By','Update At'];
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

        $searchAssignment = "%$this->searchAssignment%";
        $list=Assignment::with(['scheduling','referral','carrier','status','event','phones','user_updated','user_created','job_types','invoices'])->whereLike('first_name',$searchAssignment)
            ->whereLike('id',$searchAssignment)
            ->whereLike('last_name',$searchAssignment)
            ->whereLike('email',$searchAssignment)
            ->whereLike('street',$searchAssignment)
            ->whereLike('city',$searchAssignment)
            ->whereLike('state',$searchAssignment)
            ->whereLike('zipcode',$searchAssignment)
            ->whereLike('claim_number',$searchAssignment)
            ->orderBy('id', 'DESC');


        $list = $list->paginate($this->selectedRows);


//        $list=$list->sortBy('order_status')->sortBy('start_date');
//
//
//
////        $offset = max(0, ($this->page - 1) * $this->selectedRows);
////        $items = $list->slice($offset, $this->selectedRows + 1);
////
////        $list = new Paginator($items, $this->selectedRows, $this->page);
//
//
//        $items = $list->forPage($this->page, $this->selectedRows);
//
//        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);
////        $list = $list->paginate($this->selectedRows);

        return view('assignments::livewire.list.list-all', [
            'list' =>$list
        ]);

    }
}
