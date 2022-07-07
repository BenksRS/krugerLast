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

    public $columns = ['Name','Job Type','Schedule','Status','Referral','City','State', 'Created At','invoice`s', 'Billied Date', 'Total Invoice Amount', 'Paid Date', 'Paid Amount', 'Balance Amount'];
    public $selectedColumns = [];
    public $selectedRows = 500;
    public $searchInfo;


    public function mount()
    {
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

     if($this->searchInfo){
         $list =  $this->getResults($this->searchInfo);
         $list= $list->sortBy('start_date')->sortBy('order_status');
         $this->emit('balanceInfo', $list);

     }else{
         $list =[];
     }


        return view('reports::livewire.info.jobs',[
                'list'=>$list
        ]
        );
    }
}
