<?php

namespace Modules\Reports\Http\Livewire\Info;

use Carbon\Carbon;
use Livewire\Component;
use Manny\Manny;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\User\Entities\Techs;

class Search extends Component
{
    public $filter_date='schedulled';

    public $techs;
    public $date_from;
    public $date_from_edit;
    public $date_to;
    public $date_to_edit;

    public  function mount(){

    }


    public function search()
    {


        $data=(object)[
            'date_from' =>$this->date_from,
            'date_to' =>$this->date_to,
            'filter_by' =>$this->filter_date
        ];




        $this->emit('searchResult', $data);
    }
    public function render()
    {
        return view('reports::livewire.info.search');
    }
}
