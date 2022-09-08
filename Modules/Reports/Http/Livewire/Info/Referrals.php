<?php

namespace Modules\Reports\Http\Livewire\Info;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;

class Referrals extends Component
{
    use WithPagination;

    protected $listeners = [
        'searchResult'
    ];
    protected $paginationTheme = 'bootstrap';

    public $columns = ['Name','Job Type','Schedule','Status','Referral','City','State', 'Created At','invoice`s', 'Billied Date', 'Total Invoice Amount', 'Paid Date', 'Paid Amount', 'Balance Amount'];
    public $selectedColumns = [];
    public $selectedRows = 100;
    public $searchInfo;
    public $jobs;


    public function mount($test){
//        $this->list= $test;
        $this->getRefJobs($test);
        $this->selectedColumns = $this->columns;

    }
    public function showMoney($var){
        return number_format($var,2,'.',',');
    }
    public function getRefJobs($test){

        $jobsbyReferral=$test->groupBy('referral_carrier_full');

        if(count($jobsbyReferral) > 0){
            foreach ($jobsbyReferral as $ref_name => $jobsRef) {

                $total = count($jobsRef);


                $coll[]=(object)[
                    'id' => rand(1,10000000),
                    'total' => $total,
                    'jobs' => $jobsRef,
                    'ref' => $ref_name,
                ];



            }
            $coll=collect($coll);
        }else {
            $coll = [];
        }

        $this->list = $coll;

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


        $list = $this->list;
        $list = $list->sortBy('ref');

//        $list;
//        $list = $list->groupBy('company_fictitions');

        $items = $list->forPage($this->page, $this->selectedRows);

        $listaall = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('reports::livewire.info.referrals',[
            'listALl'=>$listaall
        ]);
    }
}
