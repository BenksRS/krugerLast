<?php

namespace Modules\Reports\Http\Livewire\Info;

use Carbon\Carbon;
use Livewire\Component;
use Manny\Manny;
use Modules\Assignments\Entities\AssignmentsEvents;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Assignments\Repositories\AssignmentRepository;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralType;
use Modules\User\Entities\Marketing;
use Modules\User\Entities\Techs;
use Modules\User\Entities\User;
use Auth;


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
    public $commissions;
    public $commissionsSelected;

    public $events;
    public $eventSelected;

    public $allReferrals;
    public $allCarriers;
    public $jtSelected;

    public $referralSelected;
    public $job_types;
    public $ref_type;
    public $reftypeSelected;
    public $byState;
    public $carrierSelected;

    public $date_from;
    public $date_from_edit;
    public $date_to;
    public $date_to_edit;
    public $list;

    public $user;

    public  function mount(){
        $this->techs = Techs::where('active','Y')->get();
        $this->commissions = User::where('active','Y')->get();
        $this->marketing = Marketing::all();
        $this->events = AssignmentsEvents::all();
        $this->ref_type = ReferralType::all();
        $this->job_types = AssignmentsJobTypes::where('active','Y')->get();
        $this->allReferrals = Referral::all();
        $this->allCarriers = Referral::all();

        $this->user = Auth::user();





    }
    public function updated($field)
    {
        $this->list = [];

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
            case 'referral':
                switch ($this->filter_date){
                    case 'created':
                        $this->list=AssignmentFinanceRepository::DateCreated($date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                        break;
                    case 'schedulled':
                        $this->list=AssignmentFinanceRepository::DateSchedulled($date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                        break;
                    case 'billed':
                        $this->list=AssignmentFinanceRepository::DateBilled($date_from,$date_to,$this->techSelected,$this->commissionsSelected,$this->jtSelected)->get();
                        $this->list = $this->list->where('status_id', 5);
                        if($this->techSelected){
                            $tech_id = is_array($this->techSelected) ? $this->techSelected : [$this->techSelected];
                            $this->list=$this->list->whereIn('scheduling.tech_id', $tech_id);
                        }
                        break;
                    case 'paid':
                        $this->list=AssignmentFinanceRepository::DatePaid($date_from,$date_to,$this->commissionsSelected)->get();
                        break;
                    case 'crane':
                        $this->list=AssignmentFinanceRepository::DateCrane($date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                    case 'open-reschedule':
                        $this->list=AssignmentFinanceRepository::DateByStatus([1,11],$date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                    case 'readytoinstall':
                        $this->list=AssignmentFinanceRepository::DateByStatus([17],$date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                    case 'readytobill':
                        $this->list=AssignmentFinanceRepository::DateByStatus([4],$date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                    case 'trip_charge':
                        $this->list=AssignmentFinanceRepository::DateByStatus([59],$date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                    case 'tree_signed':
                        $this->list=AssignmentFinanceRepository::DateByStatus([28],$date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                    case 'next_week':
                        $this->list=AssignmentFinanceRepository::DateByStatus([31],$date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                    case 'waiting_reply':
                        $this->list=AssignmentFinanceRepository::DateByStatus([43],$date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                    case 'tree_easy':
                        $this->list=AssignmentFinanceRepository::DateByStatus([41],$date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                    case 'ready_to_install_tarp':
                        $this->list=AssignmentFinanceRepository::DateByStatus([66],$date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                    case 'docusing_sent':
                        $this->list=AssignmentFinanceRepository::DateByStatus([14],$date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                    case 'gus_problem':
                        $this->list=AssignmentFinanceRepository::DateByStatus([67],$date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                    case 'frontline':
                        $this->list=AssignmentFinanceRepository::DateByStatus([63],$date_from,$date_to,$this->techSelected,$this->jtSelected)->get();
                    break;
                }
                if($this->eventSelected){
//
                    $this->list=$this->list->where('event_id', $this->eventSelected);
                }
//            if($this->jtSelected){
////                dd($this->jtSelected);
//                $this->list=$this->list->whereIn('job_types', $this->jtSelected);
//
//            }
                if($this->referralSelected){
//                    dd('referralSelected');
                    $this->list=$this->list->where('referral_id', $this->referralSelected);
                }
            if($this->reftypeSelected){
//                    dd('referralSelected');
                $this->list=$this->list->where('referral.referral_type_id', $this->reftypeSelected);
            }
            if($this->byState){
//                    dd('referralSelected');
                $this->list=$this->list->whereIn('state', $this->byState);
                
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