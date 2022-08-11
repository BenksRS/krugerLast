<?php

namespace Modules\Employees\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class EmployeeReceipts extends Model
{
    use HasFactory;
    protected $table    = 'employee_receipts';
    protected $fillable = [
        'user_id',
        'b64',
        'amount',
        'status',
        'category',
        'created_by',
        'updated_by',
        'approved_by',
        'approved_at'
    ];
    protected $appends=[
        'created_view',
        'approved_view',
        'paid_view',
        'amount_view'
    ];

    public function user_created()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function user_updated()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function user_approved()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
    public function getAmountViewAttribute ()
    {
        $result = number_format($this->amount, 2);
        return "$$result";
    }
    public function getCreatedViewAttribute(){

        $return = "-";
        if($this->created_at){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('m/d/Y g:i A');
        }
        return $return;
    }
    public function getApprovedViewAttribute(){

        $return = "-";
        if($this->approved_at){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->approved_at)->format('m/d/Y g:i A');
        }
        return $return;
    }
    public function getPaidViewAttribute(){

        $return = "-";
        if($this->approved_at){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->approved_at)->format('m/d/Y g:i A');
        }
        return $return;
    }
    protected static function newFactory()
    {
        return \Modules\Employees\Database\factories\EmployeeReceiptsFactory::new();
    }
}
