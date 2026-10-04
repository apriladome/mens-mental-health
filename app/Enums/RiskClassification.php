<?php

declare(strict_types=1);

namespace App\Enums;

enum RiskClassification: string
{
    case LOW = 'low';
    case MILD = 'mild';
    case MODERATE = 'moderate';
    case SEVERE = 'severe';
    case ACUTE = 'acute';

    /**
     * Map a numerical PHQ-9 total score to its validated clinical severity tier.
     */
    public static function fromPhq9Score(int $score): self
    {
        return match (true) {
            $score >= 20 => self::ACUTE,
            $score >= 15 => self::SEVERE,
            $score >= 10 => self::MODERATE,
            $score >= 5  => self::MILD,
            default      => self::LOW,
        };
    }

    /**
     * Human-readable label free of clinical jargon.
     */
    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Minimal Strain',
            self::MILD => 'Mild Operational Strain',
            self::MODERATE => 'Moderate Functional Load',
            self::SEVERE => 'Severe Operational Depletion',
            self::ACUTE => 'Acute Crisis / Immediate Triage',
        };
    }
}