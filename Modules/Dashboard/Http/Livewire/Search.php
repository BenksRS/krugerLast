<?php

namespace Modules\Dashboard\Http\Livewire;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\FinanceBilling;
use Modules\Assignments\Repositories\AssignmentRepository;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Repositories\ReferralsRepository;

class Search extends Component
{

    public $searchAll;


    public function render()
    {

        $list = $refs = $invs = [];
        if($this->searchAll != ''){
            $searchAll = "%$this->searchAll%";

//            $list=AssignmentRepository::Search($searchAll)->get();
            $list = AssignmentRepository::searchtop($this->searchAll)->get();
//            dd($list);
//            $refs = ReferralsRepository::searchtopref($this->searchAll)->get();
//            dd($refs);
//            $refs = Referral::whereLike('company_entity',$searchAll)
//                ->whereLike('company_fictitions',$searchAll)
//                ->whereLike('street',$searchAll)
//                ->get();
//
//            $invs = FinanceBilling::whereLike('invoice_id',$searchAll)->get();

        }


        return view('dashboard::livewire.search',[
            'jobs' => $list,
            'refs' => $refs,
            'invoices' => $invs
        ]);
    }
}
