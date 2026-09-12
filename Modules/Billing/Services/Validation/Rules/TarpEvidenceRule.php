<?php

namespace Modules\Billing\Services\Validation\Rules;

use Modules\Billing\Services\Validation\ConfidenceLevel;
use Modules\Billing\Services\Validation\RuleInterface;

/**
 * Tarp exige evidência de instalação + área defensável — regra citada
 * explicitamente pela Joline como um dos maiores pontos de erro hoje.
 */
class TarpEvidenceRule implements RuleInterface
{
    public function evaluate(array $lineItem, array $context): array
    {
        $haystack = strtolower(($lineItem['description'] ?? '') . ' ' . ($lineItem['xactimate_code'] ?? ''));

        if (!str_contains($haystack, 'tarp')) {
            return [];
        }

        $jobReport = $context['job_report'] ?? null;

        if (!$jobReport || empty($jobReport->tarp_situation)) {
            return [[
                'field' => 'tarp_area_evidence',
                'confidence' => ConfidenceLevel::LOW,
                'reasoning' => 'Job Report não descreve a situação do tarp (área/localização) — sem base para cobrar automaticamente.',
            ]];
        }

        if (empty($lineItem['quantity'])) {
            return [[
                'field' => 'tarp_area_evidence',
                'confidence' => ConfidenceLevel::LOW,
                'reasoning' => 'Situação do tarp descrita no Job Report, mas quantidade/área (SF) não informada no item.',
            ]];
        }

        return [[
            'field' => 'tarp_area_evidence',
            'confidence' => ConfidenceLevel::MEDIUM,
            'reasoning' => 'Job Report descreve a situação do tarp e há quantidade informada — confirmar fotos de instalação antes de HIGH.',
        ]];
    }
}
