<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;

class BillingLineItem extends Model
{
    protected $table = 'billing_line_items';

    protected $fillable = [
        'billing_plan_id',
        'category',
        'xactimate_code',
        'description',
        'quantity',
        'unit',
        'unit_price',
        'total',
        'confidence',
        'confidence_fields',
        'evidence',
        'reasoning',
        'matched_real_line_item',
    ];

    protected $casts = [
        'confidence_fields' => 'array',
        'evidence' => 'array',
        'matched_real_line_item' => 'array',
    ];

    public function plan()
    {
        return $this->belongsTo(BillingPlan::class, 'billing_plan_id', 'id');
    }

    public function exceptions()
    {
        return $this->hasMany(BillingException::class, 'billing_line_item_id', 'id');
    }
}
