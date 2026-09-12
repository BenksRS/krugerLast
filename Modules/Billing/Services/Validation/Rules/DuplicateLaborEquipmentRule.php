<?php

namespace Modules\Billing\Services\Validation\Rules;

use Modules\Billing\Services\Validation\ConfidenceLevel;
use Modules\Billing\Services\Validation\RuleInterface;

/**
 * Evita cobrar operador/mão de obra separadamente quando já está incluído
 * no item de equipamento — ponto de erro citado pela Joline.
 */
class DuplicateLaborEquipmentRule implements RuleInterface
{
    public function evaluate(array $lineItem, array $context): array
    {
        if (($lineItem['category'] ?? null) !== 'labor') {
            return [];
        }

        $planItems = $context['plan_items'] ?? [];
        $description = strtolower($lineItem['description'] ?? '');

        foreach ($planItems as $existing) {
            if (($existing['category'] ?? null) !== 'equipment') {
                continue;
            }

            $existingDescription = strtolower($existing['description'] ?? '');

            // Heurística simples v1: mesma palavra-chave de equipamento aparecendo num item de labor.
            foreach (['crane', 'climber', 'bobcat', 'skid', 'mini'] as $keyword) {
                if (str_contains($description, $keyword) && str_contains($existingDescription, $keyword)) {
                    return [[
                        'field' => 'duplicate_labor',
                        'confidence' => ConfidenceLevel::CONFLICT,
                        'reasoning' => "Possível duplicidade: mão de obra de '{$keyword}' pode já estar incluída no item de equipamento correspondente.",
                    ]];
                }
            }
        }

        return [];
    }
}
