<?php

declare(strict_types=1);

namespace App\Actions\Tracking;

use App\Models\HabitDefinition;
use App\Models\HabitLog;
use App\Models\User;
use Carbon\Carbon;

class ToggleHabitCompletionAction
{
    /**
     * Toggle a habit's completion status for a given day (defaults to today).
     */
    public function execute(User $user, HabitDefinition $habit, ?Carbon $date = null): bool
    {
        $targetDate = $date ?? Carbon::today();

        $existingLog = HabitLog::where('user_id', $user->id)
            ->where('habit_definition_id', $habit->id)
            ->whereDate('completed_at', $targetDate)
            ->first();

        if ($existingLog) {
            // Already completed today: toggle off (delete)
            $existingLog->delete();
            return false;
        }

        // Toggle on: create completion entry
        HabitLog::create([
            'user_id' => $user->id,
            'habit_definition_id' => $habit->id,
            'completed_at' => $targetDate->isToday() ? Carbon::now() : $targetDate->copy()->setTime(12, 0),
        ]);

        return true;
    }
}