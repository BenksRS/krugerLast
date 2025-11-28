<?php

namespace Modules\Reports\Http\Livewire\Info;

use Livewire\Component;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;

class Finance extends Component
{
    protected $listeners = [
        'balanceInfo'
    ];

    public $result;
    public $list;
    public $retorno=[];


    public function mount($test){
        $this->list=$test;

        $this->balanceInfo();
    }

    public function numberFormat($value)
    {
        $result = number_format($value, 2);
        return "$$result";
}
    public function balanceInfo()
    {

//        dd($this->list);
        if($this->list){
//            dd($this->list);
            $this->result = collect($this->list);

            $total_jobs_closed=count($this->result->where('status_id',7));
            $total_jobs_open=count($this->result->whereIn('status_id',[1,2,3,12,11,14,17,18,22]));
            $total_jobs_completed=count($this->result->whereIn('status_id',[4,5,6,8,9,10,13,15,19,20,21,23,24]));
            $total_jobs=count($this->result);

            // billed
            $jobs_billed=$this->result->whereIn('status_id',[5,6,9,10,24]);
            $total_jobs_billed=count($jobs_billed);

            $total_billing=$this->result->sum('finance.invoices.total');

            $total_tree_billing= $this->result->sum('finance.invoices.tree_amount');
            if($total_billing == 0){
                $media_jobs_billed=0;
            }else{
                $media_jobs_billed=$total_billing/$total_jobs_billed;
            }


            // paid
            $jobs_paid=$this->result->whereIn('status_id',[6,9,10,24]);
            $total_jobs_paid=count($jobs_paid);
//dump(total_billing)
            $total_paid=$this->result->sum('finance.payments.total');

            if($total_paid == 0){
                $media_jobs_paid=0;
            }else{
                $media_jobs_paid=$total_paid/$total_jobs_paid;
            }

            // jobs Direct Bill
            $total_jobs_direct_bill = count($this->result->where('carrier_id',66));



            $this->retorno=[
                'total' =>$total_jobs,
                'open' =>$total_jobs_open,
                'completed' =>$total_jobs_completed,
                'closed' =>$total_jobs_closed,
                'billing' =>$total_jobs_billed,
                'total_billing' =>$this->numberFormat($total_billing),
                'total_tree_billing' =>$this->numberFormat($total_tree_billing),
                'media_billing' =>$this->numberFormat($media_jobs_billed),
                'paid' =>$total_jobs_paid,
                'total_paid' =>$this->numberFormat($total_paid),
                'media_paid' =>$this->numberFormat($media_jobs_paid),
                'direct_bill' =>$total_jobs_direct_bill
            ];
        }else{
            $this->retorno=[];
        }


    }


    public function render()
    {
        return view('reports::livewire.info.finance');
    }
}