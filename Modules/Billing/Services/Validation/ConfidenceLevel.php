<?php

namespace Modules\Billing\Services\Validation;

class ConfidenceLevel
{
    const HIGH = 'HIGH';
    const MEDIUM = 'MEDIUM';
    const LOW = 'LOW';
    const CONFLICT = 'CONFLICT';

    // Do pior para o melhor — usado para achar o "pior confidence" entre campos/itens.
    const ORDER = [self::CONFLICT, self::LOW, self::MEDIUM, self::HIGH];

    public static function worstOf(array $levels): string
    {
        $levels = array_values(array_unique(array_filter($levels)));

        if (empty($levels)) {
            return self::HIGH;
        }

        foreach (self::ORDER as $level) {
            if (in_array($level, $levels, true)) {
                return $level;
            }
        }

        return self::MEDIUM;
    }
}
