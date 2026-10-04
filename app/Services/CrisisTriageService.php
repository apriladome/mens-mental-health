<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\CrisisEscalationLog;
use App\Models\User;
use App\Notifications\ClinicalEmergencyAlertNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class CrisisTriageService
{
    /**
     * Alert all on-call clinical directors regarding an acute crisis event.
     */
    public function alertClinicalDirectors(CrisisEscalationLog $log): int
    {
        // Fetch all clinical directors or super admins
        $supervisors = User::role(['clinical_director', 'super_admin'])->get();

        if ($supervisors->isNotEmpty()) {
            Notification::send($supervisors, new ClinicalEmergencyAlertNotification($log));
        }

        return $supervisors->count();
    }

    /**
     * Assign a specific clinician/supervisor to take ownership of this incident.
     */
    public function assignResponder(CrisisEscalationLog $log, User $clinician): CrisisEscalationLog
    {
        $log->update([
            'clinician_dispatched_id' => $clinician->id,
        ]);

        return $log->fresh(['clinicianDispatched']);
    }

    /**
     * Formally resolve the safety incident with clinical sign-off notes.
     */
    public function resolveIncident(
        CrisisEscalationLog $log,
        User $responder,
        string $resolutionNotes
    ): CrisisEscalationLog {
        if ($log->resolved_at !== null) {
            throw ValidationException::withMessages([
                'crisis_log' => ['This safety incident has already been resolved.'],
            ]);
        }

        $log->update([
            'clinician_dispatched_id' => $responder->id,
            'resolved_at' => Carbon::now(),
            'resolution_notes' => trim($resolutionNotes),
        ]);

        return $log->fresh(['clinicianDispatched']);
    }
}