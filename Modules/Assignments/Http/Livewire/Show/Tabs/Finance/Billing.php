<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Finance;

use Carbon\Carbon;
use Livewire\Component;
use Manny\Manny;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsJobTypesPivot;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Modules\Assignments\Entities\FinanceBilling;
use Auth;
use Modules\Assignments\Entities\JobReport;

class Billing extends Component
{
    protected $listeners = [
        'addInvoice' => 'processNewinvoice',
        'invoiceUpdate' => 'processinvoiceUpdate',
        'editInvoice' => 'processEditinvoice',
        'disableInvoice' => 'processDisableInvoice'
        ];
    public $assignment;
    public $invoices;
    public $showAdd = false;

    public $checkJobreport=0;

    public $invoice_id;
    public $billed_amount;
    public $billed_amount_tr;
    public $fee_amount;
    public $fee_amount_tr;
    public $collection_fee_amount;
    public $collection_fee_amount_tr;
    public $discount_amount;
    public $discount_amount_tr;
    public $settlement_amount;
    public $tree_amount;
    public $tree_amount_tr;
    public $settlement_amount_tr;
    public $billed_date_edited;
    public $invoice_total;
    public $billed_date;

    public $user;
    public $job_types;

    protected $rules = [
        'invoice_id' => 'required',
        'billed_amount_tr' => 'required',
        'collection_fee_amount_tr' => 'required',
        'fee_amount_tr' => 'required',
        'discount_amount_tr' => 'required',
        'settlement_amount_tr' => 'required'
    ];

    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->invoices = FinanceBilling::where('assignment_id', $this->assignment->id)->orderBy('invoice_id', 'ASC')->orderBy('id', 'DESC')->get();
        $this->invoice_total = 0;
        $this->user = Auth::user();

        $job_types = AssignmentsJobTypesPivot::where('assignment_id', $this->assignment->id)->where('assignment_job_type_id',11)->get();
        $this->job_types = count($job_types);





        $this->checkJobreport = count(JobReport::where('assignment_id', $this->assignment->id)->get());


    }
    public function updated($field)
    {
        $array = array('billed_amount', 'fee_amount','collection_fee_amount', 'discount_amount', 'settlement_amount', 'tree_amount');

        if (in_array($field, $array))
        {
            $this->{$field} = ($this->{$field} != '') ? number_format(preg_replace('/[^0-9.]+/', '', $this->{$field}), 2) : '';
            $this->invoiceTotal();
        }
    }


    public function processEditinvoice($id){

        $invoice = FinanceBilling::find($id);

        $this->invoice_id = $invoice->invoice_id;
        $this->billed_amount = $invoice->billed_amount;
        $this->fee_amount = $invoice->fee_amount;
        $this->collection_fee_amount = $invoice->collection_fee_amount;
        $this->discount_amount = $invoice->discount_amount;
        $this->settlement_amount = $invoice->settlement_amount;
        $this->billed_date = $invoice->billed_date;
        $this->billed_date_edited = $invoice->billed_date;

        $this->invoiceTotal();

        $this->showAdd = true;
    }
    public function processDisableInvoice($id){
        if($id == null) return;
        FinanceBilling::where('id', $id)->update(['type' => 'disable', 'updated_by' => $this->user->id]);
        $this->invoices = FinanceBilling::where('assignment_id', $this->assignment->id)->orderBy('invoice_id', 'ASC')->orderBy('id', 'DESC')->get();
        $this->emit('balanceReload');

    }
    public function processinvoiceUpdate(){
        $this->invoices = FinanceBilling::where('assignment_id', $this->assignment->id)->orderBy('invoice_id', 'ASC')->orderBy('id', 'DESC')->get();
    }
    public function processNewinvoice(){
        $this->showAdd = true;
    }
    public function invoiceTotal(){
        $billed_amount_tr=($this->billed_amount != '') ? preg_replace('/[^0-9.]+/', '', $this->billed_amount) : 0;
        $this->billed_amount_tr = $billed_amount_tr;
        $fee_amount_tr=($this->fee_amount != '') ? preg_replace('/[^0-9.]+/', '', $this->fee_amount) : 0;
        $this->fee_amount_tr = $fee_amount_tr;
        $collection_fee_amount_tr=($this->collection_fee_amount != '') ? preg_replace('/[^0-9.]+/', '', $this->collection_fee_amount) : 0;
        $this->collection_fee_amount = $collection_fee_amount_tr;

        $discount_amount_tr=($this->discount_amount != '') ? preg_replace('/[^0-9.]+/', '', $this->discount_amount) : 0;
        $this->discount_amount_tr = $discount_amount_tr;
        $settlement_amount_tr=($this->settlement_amount != '') ? preg_replace('/[^0-9.]+/', '', $this->settlement_amount) : 0;
        $this->settlement_amount_tr = $settlement_amount_tr;

        $tree_amount_tr=($this->tree_amount != '') ? preg_replace('/[^0-9.]+/', '', $this->tree_amount) : 0;
        $this->tree_amount_tr = $tree_amount_tr;

        $this->invoice_total =number_format($billed_amount_tr - ($fee_amount_tr+$discount_amount_tr+$settlement_amount_tr),2);
    }

    public function disabledInvoices($assignment_id, $invoice_id){
        $invoice_history = FinanceBilling::where('assignment_id', $assignment_id)->where('invoice_id', $invoice_id)->get();

        $data['type']='disable';
        $data['updated_by']=$this->user->id;
        foreach ($invoice_history as $inv){
            $inv->update($data);
        }
    }
    public function newInvoice($formData){
        $this->billed_date = $formData['billed_date'];
        $errors = $this->getErrorBag();
        $this->disabledInvoices($this->assignment->id, $this->invoice_id);
//        if($this->billed_date != $this->billed_date_edited){
//            $this->billed_date = Carbon::createFromFormat('Y-m-d  H:i', $this->billed_date)->format('Y-m-d H:i:s');
//        }

        $data=[
            'invoice_id' => $this->invoice_id,
            'assignment_id' => $this->assignment->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
            'billed_amount' => $this->billed_amount_tr,
            'fee_amount' =>$this->fee_amount_tr,
            'collection_fee_amount' =>$this->collection_fee_amount_tr,
            'discount_amount' =>$this->discount_amount_tr,
            'settlement_amount' =>$this->settlement_amount_tr,
            'type' => 'active',
            'billed_date' =>$this->billed_date,

        ];
        if($this->job_types > 0){
            $data['tree_amount']=$this->tree_amount_tr;
        }

        if($this->invoice_total == 0){
            $data['status'] = 'paid';
        }

        FinanceBilling::create($data)->save();

        $this->invoice_id = $this->billed_amount = $this->billed_amount_tr = $this->fee_amount = $this->fee_amount_tr = $this->collection_fee_amount_tr =$this->discount_amount = $this->discount_amount_tr = $this->settlement_amount = $this->settlement_amount_tr = $this->billed_date = null;
//        $this->invoices = FinanceBilling::where('assignment_id', $this->assignment->id)->orderBy('invoice_id', 'ASC')->orderBy('billed_date', 'ASC')->get();
        $this->invoices = FinanceBilling::where('assignment_id', $this->assignment->id)->orderBy('invoice_id', 'ASC')->orderBy('id', 'DESC')->get();
        $this->showAdd = false;
        $this->emit('balanceReload');

    }


    public function render()
    {
        return view('assignments::livewire.show.tabs.finance.billing',[
            'listInvoices' => $this->invoices
        ]);
    }
}