<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\JobReport;

class BillingPlan extends Model
{
    protected $table = 'billing_plans';

    protected $fillable = [
        'assignment_id',
        'job_report_id',
        'status',
        'overall_confidence',
        'generated_by',
        'notes',
        'real_estimate_total',
        'plan_total',
        'total_variance',
        'compared_at',
    ];

    protected $casts = [
        'compared_at' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id', 'id');
    }

    public function jobReport()
    {
        return $this->belongsTo(JobReport::class, 'job_report_id', 'id');
    }

    public function lineItems()
    {
        return $this->hasMany(BillingLineItem::class, 'billing_plan_id', 'id');
    }

    public function exceptions()
    {
        return $this->hasMany(BillingException::class, 'billing_plan_id', 'id');
    }

    public function auditEntries()
    {
        return $this->hasMany(BillingAuditEntry::class, 'billing_plan_id', 'id');
    }
}
