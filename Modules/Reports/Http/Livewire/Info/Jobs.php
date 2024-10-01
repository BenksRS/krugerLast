<?php

namespace Modules\Reports\Http\Livewire\Info;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Assignments\Repositories\AssignmentRepository;

class Jobs extends Component
{
    use WithPagination;

    protected $listeners = [
        'searchResult'
    ];
    protected $paginationTheme = 'bootstrap';

    public $columns = ['Name','Job Type','Schedule','Status','Referral','City','State', 'Created At','invoice`s', 'Billied Date', 'Total Invoice Amount', 'Paid Date', 'Paid Amount', 'Balance Amount', 'Claim Number', 'Billed By'];
    public $selectedColumns = [];
    public $selectedRows = 100;
    public $searchInfo;
    public $jobs;


    public function mount($test){
        $this->list= $test;
        $this->selectedColumns = $this->columns;

    }

    public function searchResult($result)
    {
        $this->searchInfo = $result;
    }

    public function getResults($results)
    {
        $results=(object)$results;
        $date_from = strtotime($results->date_from);
        $date_from = date('Y-m-d', $date_from);
        $date_to = strtotime($results->date_to);
        $date_to =  date('Y-m-d', $date_to);

        return AssignmentFinanceRepository::DateSchedulled($date_from,$date_to)->get();
    }
    public function render()
    {


            $list =  $this->list;
            $list= $list->sortBy('start_date')->sortBy('order_status');

            $items = $list->forPage($this->page, $this->selectedRows);

        $listaall = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);





        return view('reports::livewire.info.jobs',[
                'listALl'=>$listaall
            ]
        );
    }
}
