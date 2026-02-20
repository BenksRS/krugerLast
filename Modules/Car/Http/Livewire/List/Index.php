<?php

namespace Modules\Car\Http\Livewire\List;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Car\Entities\Car;
use Modules\Car\Entities\CarsLogs;
use Modules\Car\Repositories\CarRepository;

class Index extends Component
{
    public $auto;
    public $driver;

    public $show=false;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;



    public $columns = ['Auto','Driver','E-pass','Plate','Tag Expires','Insurance Expires','VIN'];
    public $selectedColumns = [];
    public $selectedRows = 100;

    public $sortBy;

    public function mount()
    {
        $this->selectedColumns = $this->columns;
        $this->auto = 'teste';

        $this->sortBy  = 'auto';

    }
    public function updatingSearchAssignment()
    {
        $this->resetPage();
    }





    public function render()
    {
        $searchAssignment = $this->searchAssignment;
        $list = CarRepository::Searchtop($searchAssignment)->get();

        $list=$list->sortBy($this->sortBy);

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('car::livewire.list.index', [
            'list' =>$list
        ]);
    }
}