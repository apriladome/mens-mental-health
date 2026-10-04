<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\CriticalAssessmentScoreReached;
use App\Models\CrisisEscalationLog;
use Illuminate\Support\Facades\Log;

class TriggerCrisisEscalationProtocol
{
    /**
     * Handle the event synchronously to guarantee immediate safety logging.
     */
    public function handle(CriticalAssessmentScoreReached $event): void
    {
        // 1. Create an immutable crisis escalation entry immediately
        $escalationLog = CrisisEscalationLog::create([
            'user_id' => $event->user->id,
            'trigger_source' => $event->triggerMetadata['trigger_source'] ?? 'phq9_q9',
            'severity_level' => $event->triggerMetadata['severity_level'] ?? 'imminent_danger',
            'intercept_viewed' => false,
            'clinician_dispatched_id' => null,
            'resolved_at' => null,
            'resolution_notes' => null,
        ]);

        // 2. High-priority system log entry
        Log::critical('CRITICAL CRISIS ESCALATION TRIGGERED', [
            'escalation_id' => $escalationLog->id,
            'user_id' => $event->user->id,
            'submission_id' => $event->submission->id,
            'trigger' => $event->triggerMetadata,
        ]);
    }
}