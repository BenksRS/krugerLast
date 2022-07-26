<?php

namespace Modules\Reports\Http\Livewire\Info;

use Carbon\Carbon;
use Livewire\Component;
use Manny\Manny;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Assignments\Repositories\AssignmentRepository;
use Modules\User\Entities\Techs;

class Search extends Component
{
    public $filter_date='schedulled';
    public $filter_type='referral';

    public $techs;
    public $date_from;
    public $date_from_edit;
    public $date_to;
    public $date_to_edit;
    public $list;

    public  function mount(){

    }
    public function updated($field)
    {
        if ($field == 'date_to' || $field == 'date_from')
        {
            $this->list = [];
        }
    }

    public function search()
    {


        $date_from = strtotime($this->date_from);
        $date_from = date('Y-m-d', $date_from);
        $date_to = strtotime($this->date_to);
        $date_to =  date('Y-m-d', $date_to);

        switch ($this->filter_type){
            case 'referral':
                $this->list=AssignmentFinanceRepository::DateSchedulled($date_from,$date_to)->selectRaw('referral_id ,carrier_id ,count(id) as total_jobs')->groupBy('referral_id')->groupBy('carrier_id')->get();
                break;
            case 'jobs':
                $this->list=AssignmentFinanceRepository::DateSchedulled($date_from,$date_to)->get();
                break;
        }
//        $teste =  $this->list;
//        foreach ($teste as $row){
//            dump($row->referral->company_fictitions);
//        }

    }
    public function render()
    {
        return view('reports::livewire.info.search');
    }
}
