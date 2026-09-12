<?php

namespace Modules\Billing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\JobReport;
use Modules\Billing\Repositories\BillingPlanRepository;
use Modules\Gdrive\Entities\QueeLabeling;

/**
 * Disparo do billing:generate-plan via URL, pra testar sem precisar de acesso
 * ao shell do container. Mesmo comportamento do comando artisan, só que os
 * line items vêm no request em vez de prompts interativos.
 *
 * Segue o mesmo padrão de rota utilitária sem auth já usado em Gdrive
 * (/gdrive/queue_labeling/ etc.) — não expõe dado sensível de terceiros,
 * só roda o motor de validação sobre o que for enviado.
 */
class BillingTestController extends Controller
{
    /**
     * GET/POST /billing/test/{assignment}
     *
     * Sem "items" no request: gera o plano vazio, só pra conferir que o job/job report
     * são encontrados e o plano é criado.
     *
     * Com "items": um array (JSON, se vier por querystring) de objetos
     * {category, xactimate_code, description, quantity, unit, unit_price}.
     *
     * Ex.: /billing/test/31578?items=[{"category":"equipment","xactimate_code":"EQU SKID","description":"Mini skid","quantity":3,"unit":"HR","unit_price":45}]
     */
    public function generatePlan(Request $request, $assignmentId, BillingPlanRepository $repository)
    {
        $assignment = Assignment::find($assignmentId);

        if (!$assignment) {
            return response()->json(['error' => "Assignment #{$assignmentId} não encontrado."], 404);
        }

        $jobReport = JobReport::where('assignment_id', $assignment->id)->latest('id')->first();

        $evidence = QueeLabeling::where('assignment_id', $assignment->id)
            ->where('status', 'complete')
            ->pluck('payload')
            ->all();

        $items = $request->input('items', []);
        if (is_string($items)) {
            $items = json_decode($items, true) ?: [];
        }

        $plan = $repository->createDraftPlan(
            assignmentId: $assignment->id,
            jobReportId: $jobReport?->id,
            generatedBy: null,
            notes: 'Gerado via URL de teste (billing/test), disparo manual.',
        );

        $context = [
            'job_report' => $jobReport,
            'evidence' => $evidence,
        ];

        $lineItemsResult = [];

        foreach ($items as $itemInput) {
            $itemInput['total'] = isset($itemInput['quantity'], $itemInput['unit_price'])
                && is_numeric($itemInput['quantity']) && is_numeric($itemInput['unit_price'])
                ? round($itemInput['quantity'] * $itemInput['unit_price'], 2)
                : null;

            $lineItem = $repository->addLineItem($plan, $itemInput, $context);

            $lineItemsResult[] = $lineItem->only([
                'id', 'category', 'xactimate_code', 'description', 'quantity', 'unit',
                'unit_price', 'total', 'confidence', 'confidence_fields', 'reasoning',
            ]);
        }

        $plan->refresh();

        return response()->json([
            'assignment' => [
                'id' => $assignment->id,
                'claim_number' => $assignment->claim_number,
            ],
            'job_report_found' => (bool) $jobReport,
            'plan' => $plan->only(['id', 'status', 'overall_confidence', 'plan_total']),
            'line_items' => $lineItemsResult,
            'open_exceptions' => $plan->exceptions()->where('status', 'open')->count(),
        ]);
    }
}
