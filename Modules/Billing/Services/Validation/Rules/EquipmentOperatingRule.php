<?php

namespace Modules\Billing\Services\Validation\Rules;

use Modules\Billing\Services\Validation\ConfidenceLevel;
use Modules\Billing\Services\Validation\RuleInterface;

/**
 * Confirma que o equipamento cobrado estava de fato OPERANDO no Job Report,
 * não apenas presente — pedido explícito da Joline.
 *
 * v1 conservadora: casa por palavra-chave na descrição/código Xactimate contra
 * os campos correspondentes do Job Report. Deve ser refinada com a Joline
 * conforme o mapeamento real de códigos Xactimate for validado.
 */
class EquipmentOperatingRule implements RuleInterface
{
    private const KEYWORD_MAP = [
        'crane' => ['flag' => 'crane', 'amount' => 'crane_amount'],
        'climber' => ['flag' => 'climber', 'amount' => 'climber_amount'],
        'bobcat' => ['flag' => 'bobcat_use', 'amount' => 'bobcat_hour'],
        'skid' => ['flag' => 'mini_use', 'amount' => 'mini_hour'],
        'mini' => ['flag' => 'mini_use', 'amount' => 'mini_hour'],
    ];

    public function evaluate(array $lineItem, array $context): array
    {
        if (($lineItem['category'] ?? null) !== 'equipment') {
            return [];
        }

        $jobReport = $context['job_report'] ?? null;

        if (!$jobReport) {
            return [[
                'field' => 'equipment_operating',
                'confidence' => ConfidenceLevel::LOW,
                'reasoning' => 'Não há Job Report vinculado ao plano para confirmar que o equipamento operou.',
            ]];
        }

        $haystack = strtolower(($lineItem['description'] ?? '') . ' ' . ($lineItem['xactimate_code'] ?? ''));

        foreach (self::KEYWORD_MAP as $keyword => $fields) {
            if (str_contains($haystack, $keyword)) {
                $used = (bool) ($jobReport->{$fields['flag']} ?? false);
                $amount = $jobReport->{$fields['amount']} ?? null;

                if (!$used) {
                    return [[
                        'field' => 'equipment_operating',
                        'confidence' => ConfidenceLevel::CONFLICT,
                        'reasoning' => "Job Report não indica uso de '{$keyword}' — item presente mas equipamento não confirmado como operando.",
                    ]];
                }

                if (empty($amount)) {
                    return [[
                        'field' => 'equipment_operating',
                        'confidence' => ConfidenceLevel::MEDIUM,
                        'reasoning' => "Job Report confirma uso de '{$keyword}', mas não há horas/quantidade registradas — confirmar antes de liberar automático.",
                    ]];
                }

                return [[
                    'field' => 'equipment_operating',
                    'confidence' => ConfidenceLevel::HIGH,
                    'reasoning' => "Job Report confirma '{$keyword}' operando com quantidade/horas registradas.",
                ]];
            }
        }

        // Item de equipamento sem palavra-chave reconhecida — não dá pra confirmar automaticamente ainda.
        return [[
            'field' => 'equipment_operating',
            'confidence' => ConfidenceLevel::MEDIUM,
            'reasoning' => 'Categoria equipamento sem palavra-chave reconhecida pela regra v1 — revisar manualmente.',
        ]];
    }
}
