<?php

declare(strict_types=1);

namespace App\Actions\Telehealth;

use App\Models\Appointment;
use App\Models\ClinicianProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class BookAppointmentAction
{
    public const DURATION_MINUTES = 50;

    /**
     * Book an appointment with pessimistic locking to prevent double-booking.
     */
    public function execute(
        User $client,
        ClinicianProfile $clinician,
        Carbon $startTime
    ): Appointment {
        $endTime = $startTime->copy()->addMinutes(self::DURATION_MINUTES);

        if (!$clinician->is_accepting_clients) {
            throw ValidationException::withMessages([
                'clinician' => ['This clinician is currently at maximum caseload capacity.'],
            ]);
        }

        return DB::transaction(function () use ($client, $clinician, $startTime, $endTime) {
            // Pessimistic lock: check for overlapping slots while holding row lock
            $conflictExists = Appointment::where('clinician_profile_id', $clinician->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->where('scheduled_start_time', '<', $endTime)
                          ->where('scheduled_end_time', '>', $startTime);
                })
                ->lockForUpdate()
                ->exists();

            if ($conflictExists) {
                throw ValidationException::withMessages([
                    'scheduled_start_time' => ['This consultation slot was just secured by another client. Please select another time.'],
                ]);
            }

            // Generate private room slug for WebRTC video integration
            $roomName = 'telehealth-' . Str::lower(Str::random(12));

            return Appointment::create([
                'user_id' => $client->id,
                'clinician_profile_id' => $clinician->id,
                'scheduled_start_time' => $startTime,
                'scheduled_end_time' => $endTime,
                'status' => 'confirmed',
                'telehealth_room_name' => $roomName,
                'cancellation_reason' => null,
            ]);
        });
    }
}
