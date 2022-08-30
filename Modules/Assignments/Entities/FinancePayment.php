<?php

namespace Modules\Assignments\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class FinancePayment extends Model
{
    use HasFactory;
    protected $table='finance_payment';
    protected $fillable = [
        'invoice_id',
        'payment_type',
        'type',
        'assignment_id',
        'created_by',
        'updated_by',
        'amount',
        'payment_info',
        'payment_date'
    ];
    protected $appends  = [
        'amount_view',
        'payment_date_view',
        'updated_date_view',
        ];
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function edited()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function getAmountViewAttribute ()
    {
        $result = number_format($this->amount, 2);
        return "$$result";
    }
    public function getPaymentDateViewAttribute ()
    {
        $return = "-";
        if($this->payment_date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->payment_date)->format('m/d/Y g:i A ');
        }
        return $return;
    }
    public function getUpdatedDateViewAttribute ()
    {
        $return = "-";
        if($this->updated_at){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('m/d/Y g:i A ');
        }
        return $return;
    }
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\FinancePaymentFactory::new();
    }
}
