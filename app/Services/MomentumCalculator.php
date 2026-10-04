<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\HabitLog;
use App\Models\MoodEntry;
use App\Models\User;
use Carbon\Carbon;

class MomentumCalculator
{
    public const WINDOW_DAYS = 30;
    public const ALLOWED_MONTHLY_PAUSES = 2;

    /**
     * Compute a user's rolling 30-day momentum score (0 to 100%) and consecutive operational days.
     *
     * @return array{
     *     momentum_percentage: int,
     *     active_days_count: int,
     *     grace_days_used: int,
     *     consecutive_days: int
     * }
     */
    public function calculate(User $user): array
    {
        $startDate = Carbon::today()->subDays(self::WINDOW_DAYS - 1);
        $endDate = Carbon::today();

        // 1. Fetch days with mood entries or completed habits
        $activeMoodDates = MoodEntry::where('user_id', $user->id)
            ->whereDate('logged_date', '>=', $startDate)
            ->pluck('logged_date')
            ->map(fn ($d) => Carbon::parse($d)->toDateString())
            ->toArray();

        $activeHabitDates = HabitLog::where('user_id', $user->id)
            ->whereDate('completed_at', '>=', $startDate)
            ->pluck('completed_at')
            ->map(fn ($d) => Carbon::parse($d)->toDateString())
            ->toArray();

        // Combine unique active dates
        $uniqueActiveDates = array_flip(array_unique(array_merge($activeMoodDates, $activeHabitDates)));

        // 2. Count active days in the rolling 30-day window
        $activeDaysCount = count($uniqueActiveDates);
        $momentumPercentage = (int) round(($activeDaysCount / self::WINDOW_DAYS) * 100);

        // 3. Compute consecutive operational days with 2 grace pauses
        $consecutiveDays = 0;
        $graceDaysUsed = 0;

        for ($i = 0; $i < self::WINDOW_DAYS; $i++) {
            $checkDate = $endDate->copy()->subDays($i)->toDateString();

            if (isset($uniqueActiveDates[$checkDate])) {
                $consecutiveDays++;
            } else {
                if ($graceDaysUsed < self::ALLOWED_MONTHLY_PAUSES) {
                    $graceDaysUsed++;
                    // Grace pause preserves continuity
                } else {
                    break;
                }
            }
        }

        return [
            'momentum_percentage' => min(100, $momentumPercentage),
            'active_days_count' => $activeDaysCount,
            'grace_days_used' => $graceDaysUsed,
            'consecutive_days' => $consecutiveDays,
        ];
    }
}