<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;
use LogicException;

/**
 * Append-only: acordado com a Joline que decisões de billing nunca são
 * sobrescritas, só acumulam novas entradas (quem/o quê/de-para/quando/por quê).
 */
class BillingAuditEntry extends Model
{
    protected $table = 'billing_audit_entries';

    const UPDATED_AT = null;

    protected $fillable = [
        'billing_plan_id',
        'billing_line_item_id',
        'action',
        'field',
        'old_value',
        'new_value',
        'reasoning',
        'actor',
    ];

    protected static function booted()
    {
        static::updating(function () {
            throw new LogicException('BillingAuditEntry é append-only: crie uma nova entrada em vez de atualizar uma existente.');
        });

        static::deleting(function () {
            throw new LogicException('BillingAuditEntry é append-only: registros não podem ser removidos.');
        });
    }

    public function plan()
    {
        return $this->belongsTo(BillingPlan::class, 'billing_plan_id', 'id');
    }

    public function lineItem()
    {
        return $this->belongsTo(BillingLineItem::class, 'billing_line_item_id', 'id');
    }
}
