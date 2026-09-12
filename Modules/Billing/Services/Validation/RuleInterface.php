<?php

namespace Modules\Billing\Services\Validation;

interface RuleInterface
{
    /**
     * Avalia um line item candidato contra o contexto do job (Job Report, evidências, outros
     * itens já no plano) e devolve avaliações por campo.
     *
     * $context = [
     *     'job_report' => \Modules\Assignments\Entities\JobReport|null,
     *     'evidence'   => array,   // ex: fotos labeled, aprovações
     *     'plan_items' => array,   // itens já adicionados neste plano, pra checar duplicidade
     * ]
     *
     * Retorna um array de avaliações: [ ['field' => string, 'confidence' => ConfidenceLevel::*, 'reasoning' => string], ... ]
     * Um array vazio significa "esta regra não se aplica a este item".
     */
    public function evaluate(array $lineItem, array $context): array;
}
