<?php

declare(strict_types=1);

namespace App\Livewire\Habits;

use App\Actions\Tracking\ToggleHabitCompletionAction;
use App\Models\HabitDefinition;
use App\Models\HabitLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HabitChecklist extends Component
{
    public Collection $habits;
    public array $completedHabitIds = [];

    public function mount(): void
    {
        $this->loadHabits();
    }

    public function loadHabits(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $this->habits = HabitDefinition::orderBy('id', 'asc')->get();

        $this->completedHabitIds = HabitLog::where('user_id', $user->id)
            ->whereDate('completed_at', Carbon::today())
            ->pluck('habit_definition_id')
            ->toArray();
    }

    public function toggleHabit(int $habitId, ToggleHabitCompletionAction $toggleAction): void
    {
        /** @var User $user */
        $user = Auth::user();

        $habit = HabitDefinition::findOrFail($habitId);
        $toggleAction->execute($user, $habit);

        $this->loadHabits();
        $this->dispatch('habit-toggled');
    }

    public function render(): View
    {
        return view('livewire.habits.habit-checklist');
    }
}