<?php

declare(strict_types=1);

namespace App\Actions\Tracking;

use App\Models\JournalEntry;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class StoreEncryptedJournalAction
{
    /**
     * Persist an encrypted CBT thought record or operational debrief.
     *
     * @param array{
     *     template_type: string,
     *     title: string,
     *     body: string,
     *     sentiment_heuristic?: string|null
     * } $data
     */
    public function execute(User $user, array $data): JournalEntry
    {
        $templateType = $data['template_type'] ?? 'cbt_thought_record';

        $validTemplates = ['cbt_thought_record', 'operational_debrief', 'tactical_reset', 'freewrite'];
        if (!in_array($templateType, $validTemplates, true)) {
            throw ValidationException::withMessages([
                'template_type' => ['Invalid journal template specified.'],
            ]);
        }

        // Eloquent model handles AES-256 encryption via casts defined in JournalEntry model
        return JournalEntry::create([
            'user_id' => $user->id,
            'template_type' => $templateType,
            'encrypted_title' => trim($data['title']),
            'encrypted_body' => trim($data['body']),
            'sentiment_heuristic' => $data['sentiment_heuristic'] ?? 'neutral',
        ]);
    }
}