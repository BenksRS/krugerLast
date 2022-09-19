<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Finance;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\FinanceBilling;
use Modules\Assignments\Entities\FinancePayment;
use function PHPUnit\Framework\isNull;
use Auth;

class Payment extends Component
{
    protected $listeners = [
        'newPayment' => 'processPayment',
        'refundPayment' => 'processRefund',
        'balanceReload'
    ];

    public $assignment;
    public $invoices;
    public $invoicesFees;
    public $invoicesOpen;
    public $checkInvoices=0;
    public $user;
    public $showAdd = false;
    public $showBalance = false;

    public $payments;



    public $payment_date;
    public $payment_amount;
    public $payment_type;
    public $payment_info;
    public $payment_date_edit;
    public $invoice_id;
    public $paid_fees;
    public $billing_id;

    public $invoice_total=0;
    public $partial_payment_total=0;
    public $balance_total=0;
    public $balance_class;





    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->invoices = FinanceBilling::where('assignment_id', '=',$this->assignment->id)->where('type', '=','active')->where('status', '!=', 'paid')->get();
        $this->invoicesOpen = FinanceBilling::where('assignment_id', '=',$this->assignment->id)->where('type', '=','active')->where('status', '!=', 'paid')->get();
        $this->invoicesFees = FinanceBilling::where('assignment_id', '=',$this->assignment->id)->where('type', '=','active')->where('status', 'paid')->get();

        $this->payments = FinancePayment::where('assignment_id', '=',$this->assignment->id)->orderBy('updated_at', 'DESC')->get();
        $this->user = Auth::user();
        $this->checkInvoices=count($this->invoices);
    }
    public function updated($field)
    {
        $array = array('paid_fees', 'payment_amount');

        if (in_array($field, $array))
        {
            $this->{$field} = ($this->{$field} != '') ? number_format(preg_replace('/[^0-9.]+/', '', $this->{$field}), 2) : '';
            $this->balance();
        }
    }
    public function back(){
        $this->showAdd = false;
    }
    public function balanceReload(){

        $this->invoices = FinanceBilling::where('assignment_id', '=',$this->assignment->id)->where('type', '=','active')->where('status', '!=', 'paid')->get();
        $this->invoicesOpen = FinanceBilling::where('assignment_id', '=',$this->assignment->id)->where('type', '=','active')->where('status', '!=', 'paid')->get();
        $this->invoicesFees = FinanceBilling::where('assignment_id', '=',$this->assignment->id)->where('type', '=','active')->where('status', 'paid')->get();

        $this->payments = FinancePayment::where('assignment_id', '=',$this->assignment->id)->orderBy('updated_at', 'DESC')->get();
        
        $this->checkInvoices=count($this->invoices);
    }
    public function invoiceList(){
        if($this->payment_type == 'fee_payment'){
            $this->invoices = FinanceBilling::where('assignment_id', '=',$this->assignment->id)->where('type', '=','active')->get();
            $this->showBalance = false;
        }else{
            $this->invoices = FinanceBilling::where('assignment_id', '=',$this->assignment->id)->where('type', '=','active')->where('status', '!=', 'paid')->get();
            $this->showBalance = true;
        }

    }
    public function partial_payment_invoice($invoice_id){

        $partialPaids = FinancePayment::where('assignment_id', '=',$this->assignment->id)->where('invoice_id', $invoice_id)->where('type', 'active')->get();
//        dd($partialPaids->sum('amount'));
        $this->partial_payment_total = $partialPaids->sum('amount');
    }
    public function balance(){

        $invoiceSelected = FinanceBilling::find($this->billing_id);
        if($invoiceSelected){
           $this->invoice_id = $invoiceSelected->invoice_id;

            $this->partial_payment_invoice($this->invoice_id);

           $this->invoice_total = preg_replace('/[^0-9.]+/', '', $invoiceSelected->invoice_amount_calc);

           if($this->payment_amount > 0){
               $this->balance_total = number_format($this->invoice_total - ($this->partial_payment_total + preg_replace('/[^0-9.]+/', '', $this->payment_amount)   ),2);

           }else{
               $this->balance_total = number_format($this->invoice_total-($this->partial_payment_total),2);
           }

           $this->balance_class = ($this->balance_total < 0) ? 'text-danger' : 'text-success' ;

        }
    }

    public function newPayment($formData){
//        dd($formData);
        $this->payment_date = $formData['payment_date'];
        $errors = $this->getErrorBag();

        $data=[
            'invoice_id' => $this->invoice_id,
            'assignment_id' => $this->assignment->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
            'amount' => preg_replace('/[^0-9.]+/', '', $this->payment_amount),
            'payment_type' => $this->payment_type,
            'payment_date' =>$this->payment_date,
            'payment_info' =>$this->payment_info,

        ];
        if($this->payment_type != 'fee_payment'){
            $data['type'] = 'active';
        }else{
            $data['type'] = 'disable';
        }


        FinancePayment::create($data)->save();

        $invoice_update = FinanceBilling::where('invoice_id', $this->invoice_id)->where('type', 'active')->first();
        if($invoice_update){
            switch ($this->payment_type){
                case 'partial_payment':
                    $update=['status' => 'partial_payment'];
                    $invoice_update->update($update);
                    break;
                case 'total_payment':
                    $update=['status' => 'paid'];
                    $invoice_update->update($update);
                    break;
                default:
                    break;
            }
            $this->emit('invoiceUpdate');
            $this->emit('checkFinance');
        }


        $this->payment_type = $this->invoice_id = $this->billing_id = $this->payment_date = $this->payment_amount = null;
        $this->payments = FinancePayment::where('assignment_id', '=',$this->assignment->id)->orderBy('updated_at', 'DESC')->get();
        $this->showAdd = false;
        $this->emit('balanceReload');
    }

    public function partialPaymentInvoice($invoice_id){

    }

    public function processRefund($payment_id){
            $refund = FinancePayment::find($payment_id);
            if($refund){
                $date=[
                    'payment_type' => 'refund_payment',
                    'type' => 'disable',
                ];
                $refund->update($date);

                $invoice_update = FinanceBilling::where('invoice_id', $refund->invoice_id)->where('type', 'active')->first();
                if($invoice_update){
                    $dateinfo=['status' =>'partial_payment'];
                    $invoice_update->update($dateinfo);

                    $this->invoices = FinanceBilling::where('assignment_id', '=',$this->assignment->id)->where('type', '=','active')->where('status', '!=', 'paid')->get();
                }
                $this->payments = FinancePayment::where('assignment_id', '=',$this->assignment->id)->orderBy('updated_at', 'DESC')->get();

                $this->emit('invoiceUpdate');
            }
        $this->invoices = FinanceBilling::where('assignment_id', '=',$this->assignment->id)->where('type', '=','active')->where('status', '!=', 'paid')->get();
        $this->invoicesOpen = FinanceBilling::where('assignment_id', '=',$this->assignment->id)->where('type', '=','active')->where('status', '!=', 'paid')->get();
        $this->invoicesFees = FinanceBilling::where('assignment_id', '=',$this->assignment->id)->where('type', '=','active')->where('status', 'paid')->get();

        $this->payments = FinancePayment::where('assignment_id', '=',$this->assignment->id)->orderBy('updated_at', 'DESC')->get();
        $this->emit('balanceReload');
        $this->emit('checkFinance');

    }
    public function processPayment(){
        $this->showAdd = true;
    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.finance.payment',[
            'listPayments' => $this->payments
        ]);
    }
}
