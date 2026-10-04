<?php

declare(strict_types=1);

namespace App\Services;

class ContentSentinel
{
    /**
     * High-priority crisis keywords that trigger immediate safety interception.
     *
     * @var list<string>
     */
    protected array $selfHarmTriggers = [
        'kill myself',
        'suicide',
        'end my life',
        'want to die',
        'better off dead',
        'ending it all',
        'no reason to live',
        'overdose on pills',
        'hang myself',
    ];

    /**
     * Toxic, abusive, or harassing terms flagged for silent human moderator review.
     *
     * @var list<string>
     */
    protected array $toxicityTriggers = [
        'kill yourself',
        'kys',
        'worthless piece of',
        'subhuman',
        'retard',
        'faggot',
    ];

    /**
     * Inspect text and return a structured verdict.
     *
     * @return array{
     *     verdict: 'safe'|'toxic'|'self_harm',
     *     should_quarantine: bool,
     *     matched_keyword: ?string,
     *     flag_reason: ?string
     * }
     */
    public function inspect(string $text): array
    {
        $normalized = strtolower(trim($text));

        // 1. Check for acute self-harm / suicide markers first
        foreach ($this->selfHarmTriggers as $trigger) {
            if (str_contains($normalized, $trigger)) {
                return [
                    'verdict' => 'self_harm',
                    'should_quarantine' => true,
                    'matched_keyword' => $trigger,
                    'flag_reason' => 'self_harm_risk',
                ];
            }
        }

        // 2. Check for general abuse / hate speech
        foreach ($this->toxicityTriggers as $trigger) {
            if (str_contains($normalized, $trigger)) {
                return [
                    'verdict' => 'toxic',
                    'should_quarantine' => true,
                    'matched_keyword' => $trigger,
                    'flag_reason' => 'hate_speech',
                ];
            }
        }

        // 3. Clear to publish
        return [
            'verdict' => 'safe',
            'should_quarantine' => false,
            'matched_keyword' => null,
            'flag_reason' => null,
        ];
    }
}