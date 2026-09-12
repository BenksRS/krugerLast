<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class BillingException extends Model
{
    protected $table = 'billing_exceptions';

    protected $fillable = [
        'billing_plan_id',
        'billing_line_item_id',
        'type',
        'reason',
        'status',
        'resolved_by',
        'resolved_at',
        'resolution_notes',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function plan()
    {
        return $this->belongsTo(BillingPlan::class, 'billing_plan_id', 'id');
    }

    public function lineItem()
    {
        return $this->belongsTo(BillingLineItem::class, 'billing_line_item_id', 'id');
    }

    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by', 'id');
    }
}
