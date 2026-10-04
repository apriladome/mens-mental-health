<?php

declare(strict_types=1);

namespace App\Actions\Tracking;

use App\Models\MoodEntry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class LogDailyReadinessAction
{
    /**
     * Record or update a user's 30-second daily readiness audit.
     *
     * @param array{
     *     energy_level: int,
     *     irritability_level: int,
     *     focus_level: int,
     *     sleep_quality: int,
     *     logged_date?: string|null
     * } $data
     */
    public function execute(User $user, array $data): MoodEntry
    {
        $loggedDate = $data['logged_date'] ?? Carbon::today()->toDateString();

        foreach (['energy_level', 'irritability_level', 'focus_level', 'sleep_quality'] as $field) {
            $val = (int) ($data[$field] ?? 0);
            if ($val < 1 || $val > 10) {
                throw ValidationException::withMessages([
                    $field => ["{$field} must be rated on a scale of 1 to 10."],
                ]);
            }
        }

        // Upsert by user_id and logged_date to maintain 1 entry per day
        return MoodEntry::updateOrCreate(
            [
                'user_id' => $user->id,
                'logged_date' => $loggedDate,
            ],
            [
                'energy_level' => (int) $data['energy_level'],
                'irritability_level' => (int) $data['irritability_level'],
                'focus_level' => (int) $data['focus_level'],
                'sleep_quality' => (int) $data['sleep_quality'],
            ]
        );
    }
}