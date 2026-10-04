<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use App\Actions\Tracking\LogDailyReadinessAction;
use App\Models\MoodEntry;
use App\Models\User;
use App\Services\MomentumCalculator;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DailyReadinessCard extends Component
{
    public int $energyLevel = 6;
    public int $irritabilityLevel = 4;
    public int $focusLevel = 7;
    public int $sleepQuality = 6;

    public bool $isSaved = false;
    public array $momentumStats = [];

    public function mount(MomentumCalculator $momentumCalc): void
    {
        /** @var User $user */
        $user = Auth::user();

        // Check if an entry exists for today
        $todayEntry = MoodEntry::where('user_id', $user->id)
            ->whereDate('logged_date', Carbon::today())
            ->first();

        if ($todayEntry) {
            $this->energyLevel = $todayEntry->energy_level;
            $this->irritabilityLevel = $todayEntry->irritability_level;
            $this->focusLevel = $todayEntry->focus_level;
            $this->sleepQuality = $todayEntry->sleep_quality;
            $this->isSaved = true;
        }

        $this->momentumStats = $momentumCalc->calculate($user);
    }

    public function saveReadiness(LogDailyReadinessAction $logAction, MomentumCalculator $momentumCalc): void
    {
        /** @var User $user */
        $user = Auth::user();

        $logAction->execute($user, [
            'energy_level' => $this->energyLevel,
            'irritability_level' => $this->irritabilityLevel,
            'focus_level' => $this->focusLevel,
            'sleep_quality' => $this->sleepQuality,
        ]);

        $this->isSaved = true;
        $this->momentumStats = $momentumCalc->calculate($user);

        $this->dispatch('readiness-updated');
    }

    public function render(): View
    {
        return view('livewire.dashboard.daily-readiness-card');
    }
}