<?php

namespace Modules\Billing\Services\Validation\Rules;

use Modules\Billing\Services\Validation\ConfidenceLevel;
use Modules\Billing\Services\Validation\RuleInterface;

/**
 * Acordado com a Joline: ausência de informação nunca deve virar suposição de
 * cobrança — sempre gera warning/exception em vez de inventar o dado.
 */
class MissingRequiredFieldRule implements RuleInterface
{
    public function evaluate(array $lineItem, array $context): array
    {
        $evaluations = [];

        foreach (['quantity', 'unit_price', 'description'] as $field) {
            if (empty($lineItem[$field]) && $lineItem[$field] !== 0 && $lineItem[$field] !== '0') {
                $evaluations[] = [
                    'field' => $field,
                    'confidence' => ConfidenceLevel::LOW,
                    'reasoning' => "Campo obrigatório '{$field}' não foi informado — não cobrar por suposição.",
                ];
            }
        }

        return $evaluations;
    }
}
