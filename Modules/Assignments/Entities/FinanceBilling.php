<?php

namespace Modules\Assignments\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class FinanceBilling extends Model
{
    use HasFactory;
    protected $table='finance_billing';
    protected $fillable = [
        'invoice_id',
        'assignment_id',
        'created_by',
        'updated_by',
        'billed_amount',
        'fee_amount',
        'discount_amount',
        'settlement_amount',
        'billed_date',
        'type',
        'status',
        'lien',
        'tree_amount',
    ];
    protected $appends  = [
        'billed_amount_view',
        'tree_amount_view',
        'updated_at_view',
        'billed_date_view',
        'fee_amount_view',
        'discount_amount_view',
        'settlement_amount_view',
        'invoice_amount',
        'invoice_amount_calc',
    ];

//    public function assignment(){
//        return $this->belongsTo(Assignment::class, 'assignment_id', 'id');
//    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function edited()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function getBilledAmountViewAttribute ()
    {
        $result = number_format($this->billed_amount, 2);
        return "$$result";
    }
    public function getTreeAmountViewAttribute ()
    {
        $result = number_format($this->tree_amount, 2);
        return "$$result";
    }
    public function getFeeAmountViewAttribute ()
    {
        $result = number_format($this->fee_amount, 2);
        if($this->fee_amount < 0){
            $return =  "-$$result";
        }else{
            if($this->fee_amount == 0){
                $return =  "-";
            }else{
                $return =  "-$$result";
            }

        }
        return $return;
    }
    public function getDiscountAmountViewAttribute ()
    {
        $result = number_format($this->discount_amount, 2);
        if($this->discount_amount < 0){
            $return =  "-$$result";
        }else{
            if($this->discount_amount == 0){
                $return =  "-";
            }else{
                $return =  "-$$result";
            }
        }
        return $return;
    }
    public function getSettlementAmountViewAttribute ()
    {
        $result = number_format($this->settlement_amount, 2);
        if($this->settlement_amount < 0){
            $return =  "-$$result";
        }else{
            if($this->settlement_amount == 0){
                $return =  "-";
            }else{
                $return =  "-$$result";
            }
        }
        return $return;
    }
    public function getInvoiceAmountAttribute ()
    {
        $total = ($this->billed_amount - ($this->settlement_amount + $this->discount_amount + $this->fee_amount));
        $result = number_format($total, 2);
        return "$$result";
    }
    public function getInvoiceAmountCalcAttribute ()
    {
        $total = ($this->billed_amount - ($this->settlement_amount + $this->discount_amount + $this->fee_amount));
        $result = number_format($total, 2);
        return $result;
    }

    public function getBilledDateViewAttribute (){

        $return = "-";
        if($this->billed_date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->billed_date)->format('m/d/Y g:i A ');
        }
        return $return;
    }
    public function getUpdatedAtViewAttribute (){

        $return = "-";
        if($this->updated_at){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('m/d/Y g:i A ');
        }
        return $return;
    }

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\FinanceBillingFactory::new();
    }
}
