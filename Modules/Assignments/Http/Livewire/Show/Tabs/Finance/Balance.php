<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Finance;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Modules\Assignments\Entities\FinanceBilling;
use Modules\Assignments\Entities\FinancePayment;
use Auth;

class Balance extends Component
{
    protected $listeners = [
        'balanceReload' => 'processBalance',
    ];
    public $assignment;

    public $total_invoices_amount;
    public $total_invoices_amount_calc;
    public $total_payments_amount;
    public $total_payments_amount_calc;
    public $total_balance;
    public $total_fees_after;
    public $total_fees_after_calc;

    public $user;

    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->user = Auth::user();
        $this->invoice_total();
        $this->payments_total();
        $this->balance();
    }

    public function processBalance(){
        $this->invoice_total();
        $this->payments_total();
        $this->balance();
        $this->emit('updateScheduling');
    }
    public function invoice_total(){
        $allInvoices = FinanceBilling::where('assignment_id', $this->assignment->id)->where('type', 'active')->get();
        $result=0;
        if($allInvoices){
              foreach ($allInvoices as $inv){
                  $result=$result+preg_replace('/[^0-9.]+/', '', $inv->invoice_amount_calc);
              }
        }
        $this->total_invoices_amount = number_format($result, 2);
        $this->total_invoices_amount_calc = $result;

        $this->changeStatusStatus();

    }

    public function payments_total(){
        $allPayments = FinancePayment::where('assignment_id', $this->assignment->id)->where('type', 'active')->get();
        $allPaymentsFees = FinancePayment::where('assignment_id', $this->assignment->id)->where('payment_type', 'fee_payment')->get();
        $result_payment=0;
        if($allPayments){
            foreach ($allPayments as $paid){
                $result_payment=$result_payment+preg_replace('/[^0-9.]+/', '', $paid->amount);
            }
        }
        $result_fees_after=0;
        if($allPaymentsFees){
            foreach ($allPaymentsFees as $fee){
                $result_fees_after=$result_fees_after+preg_replace('/[^0-9.]+/', '', $fee->amount);
            }
        }

        $this->total_fees_after_calc = $result_fees_after;
        $this->total_fees_after = number_format($result_fees_after, 2);
        $this->total_payments_amount = number_format($result_payment, 2);
        $this->total_payments_amount_calc = $result_payment;
    }


    public function balance(){
        $this->total_balance=number_format($this->total_invoices_amount_calc - $this->total_payments_amount_calc,2);

        $this->changeStatusStatus();
    }


    public function changeStatusStatus(){





//        // check if job is already billed
//        if( $this->total_invoices_amount_calc > 0){
//
//            $status = $this->assignment->last_status->id;
//
//            // check if is full paid
//            if( $this->total_balance == 0 && $status != 6){
//                AssignmentsStatusPivot::create([
//                    'assignment_id'=> $this->assignment->id,
//                    'assignment_status_id'=> 6,
//                    'created_by'=> $this->user->id,
//                ]);
//                $this->assignment = Assignment::find($this->assignment->id);
//                $this->emit('updateScheduling');
//                // check if is partial paid
//            }elseif($this->total_invoices_amount_calc >  $this->total_payments_amount_calc && $this->total_payments_amount_calc > 0 && $status != 10){
//                AssignmentsStatusPivot::create([
//                    'assignment_id'=> $this->assignment->id,
//                    'assignment_status_id'=> 10,
//                    'created_by'=> $this->user->id,
//                ]);
//                $this->assignment = Assignment::find($this->assignment->id);
//                $this->emit('updateScheduling');
//            }else{
//
//                if( $this->total_invoices_amount_calc > $this->total_payments_amount_calc && $this->total_balance == 0 && $status != 5){
//                    AssignmentsStatusPivot::create([
//                        'assignment_id'=> $this->assignment->id,
//                        'assignment_status_id'=> 5,
//                        'created_by'=> $this->user->id,
//                    ]);
//                    $this->assignment = Assignment::find($this->assignment->id);
//                    $this->emit('updateScheduling');
//                }
//
//            }
//
//        }
    }


    public function render()
    {
        return view('assignments::livewire.show.tabs.finance.balance');
    }
}
