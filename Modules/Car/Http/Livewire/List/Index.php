<?php

namespace Modules\Car\Http\Livewire\List;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Car\Entities\Car;
use Modules\Car\Repositories\CarRepository;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;
    public $columns = ['Auto','Driver','E-pass','Plate','Tag Expires','VIN'];
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
        $list = CarRepository::Searchtop($searchAssignment)->get();



//        $list=$list->sortBy('start_date')->sortBy('order_status');

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);


        return view('car::livewire.list.index', [
            'list' =>$list
        ]);
    }
}
