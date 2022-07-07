<?php

namespace Modules\Dashboard\Http\Livewire;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\FinanceBilling;
use Modules\Referrals\Entities\Referral;

class Search extends Component
{

    public $searchAll;


    public function render()
    {

        $list = $refs = $invs = [];
        if($this->searchAll != ''){
            $searchAll = "%$this->searchAll%";
            $list=Assignment::whereLike('id',$searchAll)
                ->whereLike('street',$searchAll)
                ->whereLike('first_name',$searchAll)
                ->whereLike('last_name',$searchAll)
                ->get();

            $refs = Referral::whereLike('company_entity',$searchAll)
                ->whereLike('company_fictitions',$searchAll)
                ->whereLike('street',$searchAll)
                ->get();

            $invs = FinanceBilling::whereLike('invoice_id',$searchAll)->get();

        }


        return view('dashboard::livewire.search',[
            'jobs' => $list,
            'refs' => $refs,
            'invoices' => $invs
        ]);
    }
}
