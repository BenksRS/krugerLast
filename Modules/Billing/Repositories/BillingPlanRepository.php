<?php

namespace Modules\Billing\Repositories;

use Modules\Billing\Entities\BillingAuditEntry;
use Modules\Billing\Entities\BillingException;
use Modules\Billing\Entities\BillingLineItem;
use Modules\Billing\Entities\BillingPlan;
use Modules\Billing\Services\Validation\ConfidenceLevel;
use Modules\Billing\Services\Validation\ValidationEngine;

class BillingPlanRepository
{
    public function __construct(private ValidationEngine $validationEngine)
    {
    }

    public function createDraftPlan(int $assignmentId, ?int $jobReportId, ?int $generatedBy, ?string $notes = null): BillingPlan
    {
        $plan = BillingPlan::create([
            'assignment_id' => $assignmentId,
            'job_report_id' => $jobReportId,
            'status' => 'draft',
            'generated_by' => $generatedBy,
            'notes' => $notes,
        ]);

        $this->audit($plan, 'plan_generated', actor: $this->actorFor($generatedBy), reasoning: 'Plano criado manualmente via billing:generate-plan.');

        return $plan;
    }

    /**
     * Avalia e persiste um line item candidato, já cruzando com o Job Report/evidências
     * disponíveis via ValidationEngine, e cria exception automaticamente se o confidence
     * final for LOW ou CONFLICT.
     */
    public function addLineItem(BillingPlan $plan, array $lineItemInput, array $context, ?int $actorId = null): BillingLineItem
    {
        $context['plan_items'] = $plan->lineItems()->get()->map->only(['category', 'description', 'xactimate_code'])->toArray();

        $evaluation = $this->validationEngine->evaluateLineItem($lineItemInput, $context);

        $lineItem = BillingLineItem::create(array_merge($lineItemInput, [
            'billing_plan_id' => $plan->id,
            'confidence' => $evaluation['confidence'],
            'confidence_fields' => $evaluation['confidence_fields'],
            'reasoning' => $evaluation['reasoning'],
        ]));

        $this->audit(
            $plan,
            'item_added',
            lineItemId: $lineItem->id,
            newValue: $lineItem->description,
            reasoning: $evaluation['reasoning'],
            actor: $this->actorFor($actorId),
        );

        $this->audit(
            $plan,
            'confidence_assigned',
            lineItemId: $lineItem->id,
            field: 'confidence',
            newValue: $evaluation['confidence'],
            reasoning: $evaluation['reasoning'],
            actor: 'system:validation_engine',
        );

        if (in_array($evaluation['confidence'], [ConfidenceLevel::LOW, ConfidenceLevel::CONFLICT], true)) {
            $this->raiseException($plan, $lineItem, strtolower($evaluation['confidence']), $evaluation['reasoning']);
        }

        $this->recalculatePlanTotals($plan);

        return $lineItem;
    }

    public function raiseException(BillingPlan $plan, ?BillingLineItem $lineItem, string $type, string $reason): BillingException
    {
        $exception = BillingException::create([
            'billing_plan_id' => $plan->id,
            'billing_line_item_id' => $lineItem?->id,
            'type' => $type,
            'reason' => $reason,
            'status' => 'open',
        ]);

        $this->audit(
            $plan,
            'exception_raised',
            lineItemId: $lineItem?->id,
            newValue: $type,
            reasoning: $reason,
            actor: 'system:validation_engine',
        );

        return $exception;
    }

    /**
     * Autoridade final combinada com a Joline: Nadal resolve as exceptions LOW/CONFLICT.
     */
    public function resolveException(BillingException $exception, int $resolvedBy, string $resolutionNotes): BillingException
    {
        $exception->update([
            'status' => 'resolved',
            'resolved_by' => $resolvedBy,
            'resolved_at' => now(),
            'resolution_notes' => $resolutionNotes,
        ]);

        $this->audit(
            $exception->plan,
            'exception_resolved',
            lineItemId: $exception->billing_line_item_id,
            newValue: 'resolved',
            reasoning: $resolutionNotes,
            actor: $this->actorFor($resolvedBy),
        );

        return $exception;
    }

    /**
     * Fase 1: comparação manual contra o estimate real feito no Xactimate,
     * enquanto não há execução/API automática.
     */
    public function compareToRealEstimate(BillingPlan $plan, float $realEstimateTotal, ?string $notes = null): BillingPlan
    {
        $planTotal = (float) $plan->plan_total;
        $variance = round($realEstimateTotal - $planTotal, 2);

        $plan->update([
            'real_estimate_total' => $realEstimateTotal,
            'total_variance' => $variance,
            'compared_at' => now(),
        ]);

        $this->audit(
            $plan,
            'compared_to_real_estimate',
            field: 'real_estimate_total',
            oldValue: (string) $planTotal,
            newValue: (string) $realEstimateTotal,
            reasoning: $notes ?? "Variância de {$variance} entre BillingPlan e estimate real.",
            actor: 'manual:comparison',
        );

        return $plan;
    }

    private function recalculatePlanTotals(BillingPlan $plan): void
    {
        $lineItems = $plan->lineItems()->get();

        $planTotal = $lineItems->sum('total');
        $overallConfidence = ConfidenceLevel::worstOf($lineItems->pluck('confidence')->all());

        $plan->update([
            'plan_total' => $planTotal,
            'overall_confidence' => $overallConfidence,
        ]);
    }

    private function audit(
        BillingPlan $plan,
        string $action,
        ?int $lineItemId = null,
        ?string $field = null,
        ?string $oldValue = null,
        ?string $newValue = null,
        ?string $reasoning = null,
        ?string $actor = null,
    ): BillingAuditEntry {
        return BillingAuditEntry::create([
            'billing_plan_id' => $plan->id,
            'billing_line_item_id' => $lineItemId,
            'action' => $action,
            'field' => $field,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'reasoning' => $reasoning,
            'actor' => $actor ?? 'unknown',
        ]);
    }

    private function actorFor(?int $userId): string
    {
        return $userId ? "user:{$userId}" : 'manual:cli';
    }
}
