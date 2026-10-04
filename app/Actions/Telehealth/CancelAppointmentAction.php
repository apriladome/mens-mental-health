<?php

declare(strict_types=1);

namespace App\Actions\Telehealth;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CancelAppointmentAction
{
    /**
     * Cancel an existing appointment and record reason.
     *
     * @param 'client'|'provider' $cancelledBy
     */
    public function execute(
        User $actor,
        Appointment $appointment,
        string $cancelledBy,
        string $reason
    ): Appointment {
        if (!in_array($appointment->status, ['pending', 'confirmed'], true)) {
            throw ValidationException::withMessages([
                'appointment' => ['Only pending or confirmed appointments can be cancelled.'],
            ]);
        }

        $newStatus = match ($cancelledBy) {
            'provider' => 'cancelled_provider',
            default => 'cancelled_client',
        };

        return DB::transaction(function () use ($appointment, $newStatus, $reason) {
            $appointment->update([
                'status' => $newStatus,
                'cancellation_reason' => trim($reason),
            ]);

            return $appointment->fresh();
        });
    }
}