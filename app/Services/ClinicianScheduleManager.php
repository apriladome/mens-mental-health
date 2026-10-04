<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Appointment;
use App\Models\ClinicianAvailability;
use App\Models\ClinicianProfile;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ClinicianScheduleManager
{
    public const SESSION_DURATION_MINUTES = 50;

    /**
     * Get available booking slots for a clinician on a specific date.
     *
     * @return Collection<int, array{
     *     start_time: string,
     *     end_time: string,
     *     is_available: bool
     * }>
     */
    public function getAvailableSlots(ClinicianProfile $clinician, Carbon $date): Collection
    {
        // 0 = Sunday, 6 = Saturday (matches Carbon::dayOfWeek)
        $dayOfWeek = $date->dayOfWeek;

        // 1. Fetch recurring availability windows for this day of week
        $availabilities = ClinicianAvailability::where('clinician_profile_id', $clinician->id)
            ->where('day_of_week', $dayOfWeek)
            ->get();

        if ($availabilities->isEmpty()) {
            return collect();
        }

        // 2. Fetch existing booked appointments for this clinician on this date
        $existingAppointments = Appointment::where('clinician_profile_id', $clinician->id)
            ->whereDate('scheduled_start_time', $date->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(['scheduled_start_time', 'scheduled_end_time']);

        $availableSlots = collect();

        foreach ($availabilities as $availability) {
            $slotStart = Carbon::parse($date->toDateString() . ' ' . $availability->start_time);
            $windowEnd = Carbon::parse($date->toDateString() . ' ' . $availability->end_time);

            // Generate 50-minute increments with 10-minute buffer (60m step)
            while ($slotStart->copy()->addMinutes(self::SESSION_DURATION_MINUTES)->lte($windowEnd)) {
                $slotEnd = $slotStart->copy()->addMinutes(self::SESSION_DURATION_MINUTES);

                // Check conflict against existing appointments
                $hasConflict = $existingAppointments->contains(function ($apt) use ($slotStart, $slotEnd) {
                    $aptStart = Carbon::parse($apt->scheduled_start_time);
                    $aptEnd = Carbon::parse($apt->scheduled_end_time);

                    return $slotStart->lt($aptEnd) && $slotEnd->gt($aptStart);
                });

                if (!$hasConflict) {
                    $availableSlots->push([
                        'start_time' => $slotStart->toDateTimeString(),
                        'end_time' => $slotEnd->toDateTimeString(),
                        'is_available' => true,
                    ]);
                }

                $slotStart->addMinutes(60); // 50m session + 10m buffer
            }
        }

        return $availableSlots;
    }
}