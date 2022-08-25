<?php

namespace Modules\Reports\Http\Livewire\Info;

use Carbon\Carbon;
use Livewire\Component;
use Manny\Manny;
use Modules\Assignments\Entities\AssignmentsEvents;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Assignments\Repositories\AssignmentRepository;
use Modules\Referrals\Entities\Referral;
use Modules\User\Entities\Marketing;
use Modules\User\Entities\Techs;

class Search extends Component
{
    protected $listeners = [
        'search'
    ];
    public $filter_date='schedulled';
    public $filter_type='jobs';

    public $marketing;
    public $marketingSelected;
    public $techs;
    public $techSelected;
    public $events;
    public $eventSelected;

    public $allReferrals;
    public $allCarriers;
    public $referralSelected;
    public $carrierSelected;

    public $date_from;
    public $date_from_edit;
    public $date_to;
    public $date_to_edit;
    public $list;

    public  function mount(){
        $this->techs = Techs::all();
        $this->marketing = Marketing::all();
        $this->events = AssignmentsEvents::all();
        $this->allReferrals = Referral::all();
        $this->allCarriers = Referral::all();
    }
    public function updated($field)
    {
//        if ($field == 'date_to' || $field == 'date_from' || $field == 'techSelected' )
//        {



            $this->list = [];
//        }
    }

    public function clear($field){

        $this->$field=null;
        $this->list = [];
    }
    public function search()
    {
        $date_from = strtotime($this->date_from);
        $date_from = date('Y-m-d', $date_from);
        $date_to = strtotime($this->date_to);
        $date_to =  date('Y-m-d', $date_to);


        switch ($this->filter_type){
            case 'jobs':
                switch ($this->filter_date){
                    case 'created':
                        $this->list=AssignmentFinanceRepository::DateSchedulled($date_from,$date_to,$this->techSelected)->get();
                        break;
                    case 'schedulled':
                        $this->list=AssignmentFinanceRepository::DateSchedulled($date_from,$date_to,$this->techSelected)->get();
                        break;
                    case 'billed':
                        $this->list=AssignmentFinanceRepository::DateBilled($date_from,$date_to)->get();
                        if($this->techSelected){
                            $this->list=$this->list->where('scheduling.tech_id', $this->techSelected);
                        }

                        break;
                    case 'paid':
                        $this->list=AssignmentFinanceRepository::DatePaid($date_from,$date_to)->get();


                        break;
                }





                if($this->eventSelected){
//                    dd('eventSelected');
                    $this->list=$this->list->where('event_id', $this->eventSelected);
                }
                if($this->referralSelected){
//                    dd('referralSelected');
                    $this->list=$this->list->where('referral_id', $this->referralSelected);
                }
                if($this->carrierSelected){
//                    dd($this->carrierSelected);
                    $this->list=$this->list->where('carrier_id', $this->carrierSelected);

                }
                if($this->marketingSelected){
//                    dd($this->marketingSelected);
                    $this->list=$this->list->where('referral.marketing_id', $this->marketingSelected);

                }
                break;
        }


    }
    public function render()
    {
        return view('reports::livewire.info.search');
    }
}
