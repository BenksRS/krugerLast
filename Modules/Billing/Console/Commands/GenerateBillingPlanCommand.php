<?php

namespace Modules\Billing\Console\Commands;

use Illuminate\Console\Command;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\JobReport;
use Modules\Billing\Repositories\BillingPlanRepository;
use Modules\Gdrive\Entities\QueeLabeling;

/**
 * Disparo manual (Fase 0/1 — sem automação ainda, conforme acordado com a Joline
 * e o Felipe). Roda o Validation Engine sobre line items informados na hora,
 * gera o BillingPlan com confidence score e exceptions, sem tocar no Xactimate.
 *
 * Uso: php artisan billing:generate-plan {assignment_id}
 */
class GenerateBillingPlanCommand extends Command
{
    protected $signature = 'billing:generate-plan {assignment_id : ID do job/assignment no CallKruger}';

    protected $description = 'Gera manualmente um BillingPlan (shadow mode) para um job, validando os itens informados contra o Job Report.';

    public function handle(BillingPlanRepository $repository): int
    {
        $assignment = Assignment::find($this->argument('assignment_id'));

        if (!$assignment) {
            $this->error("Assignment #{$this->argument('assignment_id')} não encontrado.");
            return self::FAILURE;
        }

        $jobReport = JobReport::where('assignment_id', $assignment->id)->latest('id')->first();

        if (!$jobReport) {
            $this->warn('Nenhum Job Report encontrado para este job — os itens serão avaliados sem essa evidência (tendem a LOW/MEDIUM).');
        }

        $evidence = QueeLabeling::where('assignment_id', $assignment->id)
            ->where('status', 'complete')
            ->pluck('payload')
            ->all();

        $this->info("Job #{$assignment->id} — {$assignment->first_name} {$assignment->last_name} (claim {$assignment->claim_number})");

        $plan = $repository->createDraftPlan(
            assignmentId: $assignment->id,
            jobReportId: $jobReport?->id,
            generatedBy: null,
            notes: 'Gerado via billing:generate-plan (disparo manual).',
        );

        $context = [
            'job_report' => $jobReport,
            'evidence' => $evidence,
        ];

        $this->line('Informe os line items candidatos (Enter em branco na descrição para encerrar).');

        while (true) {
            $description = $this->ask('Descrição do item');

            if (empty($description)) {
                break;
            }

            $lineItemInput = [
                'category' => $this->choice('Categoria', ['tree_removal', 'roof_tarp', 'equipment', 'labor', 'hauling', 'other'], 5),
                'xactimate_code' => $this->ask('Código Xactimate (opcional)'),
                'description' => $description,
                'quantity' => $this->ask('Quantidade'),
                'unit' => $this->ask('Unidade (ex: SF, HR, EA)'),
                'unit_price' => $this->ask('Preço unitário'),
            ];
            $lineItemInput['total'] = is_numeric($lineItemInput['quantity']) && is_numeric($lineItemInput['unit_price'])
                ? round($lineItemInput['quantity'] * $lineItemInput['unit_price'], 2)
                : null;

            $lineItem = $repository->addLineItem($plan, $lineItemInput, $context);

            $this->line("  -> confidence: {$lineItem->confidence}");
            $this->line("  -> {$lineItem->reasoning}");
        }

        $plan->refresh();

        $this->newLine();
        $this->info("BillingPlan #{$plan->id} criado — status: {$plan->status}, confidence geral: {$plan->overall_confidence}, total: {$plan->plan_total}");

        $openExceptions = $plan->exceptions()->where('status', 'open')->count();
        if ($openExceptions > 0) {
            $this->warn("{$openExceptions} exception(s) aberta(s) — precisam de revisão do Nadal antes de qualquer execução automática.");
        }

        if ($this->confirm('Já existe um estimate real (Xactimate) feito manualmente pra comparar com este plano?', false)) {
            $realTotal = (float) $this->ask('Total do estimate real');
            $repository->compareToRealEstimate($plan, $realTotal);
            $plan->refresh();
            $this->info("Variância registrada: {$plan->total_variance}");
        }

        return self::SUCCESS;
    }
}
