<?php

namespace Modules\Billing\Services\Validation;

use Modules\Billing\Services\Validation\Rules\DuplicateLaborEquipmentRule;
use Modules\Billing\Services\Validation\Rules\EquipmentOperatingRule;
use Modules\Billing\Services\Validation\Rules\MissingRequiredFieldRule;
use Modules\Billing\Services\Validation\Rules\TarpEvidenceRule;

/**
 * Motor de decisão (desacoplado da execução no Xactimate, conforme recomendado
 * pela Joline). Roda as regras de validação sobre um line item candidato e
 * devolve o confidence por campo + o confidence geral do item (o pior entre os campos).
 *
 * v1: regras conservadoras baseadas no que a Joline descreveu. A lista de
 * regras cresce conforme o processo real for observado rodando em shadow mode.
 */
class ValidationEngine
{
    /** @var RuleInterface[] */
    private array $rules;

    public function __construct(array $rules = null)
    {
        $this->rules = $rules ?? [
            new MissingRequiredFieldRule(),
            new EquipmentOperatingRule(),
            new TarpEvidenceRule(),
            new DuplicateLaborEquipmentRule(),
        ];
    }

    /**
     * @return array{confidence: string, confidence_fields: array<string,string>, reasoning: string}
     */
    public function evaluateLineItem(array $lineItem, array $context): array
    {
        $fieldConfidence = [];
        $reasoningLines = [];

        foreach ($this->rules as $rule) {
            foreach ($rule->evaluate($lineItem, $context) as $evaluation) {
                $field = $evaluation['field'];

                // Se duas regras avaliarem o mesmo campo, fica o pior confidence entre elas.
                $fieldConfidence[$field] = ConfidenceLevel::worstOf([
                    $fieldConfidence[$field] ?? ConfidenceLevel::HIGH,
                    $evaluation['confidence'],
                ]);

                $reasoningLines[] = "[{$evaluation['confidence']}] {$evaluation['reasoning']}";
            }
        }

        if (empty($fieldConfidence)) {
            $fieldConfidence['default'] = ConfidenceLevel::MEDIUM;
            $reasoningLines[] = '[MEDIUM] Nenhuma regra específica se aplicou a este item — revisar manualmente por padrão.';
        }

        return [
            'confidence' => ConfidenceLevel::worstOf(array_values($fieldConfidence)),
            'confidence_fields' => $fieldConfidence,
            'reasoning' => implode("\n", $reasoningLines),
        ];
    }
}
