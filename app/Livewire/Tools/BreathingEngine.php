<?php

declare(strict_types=1);

namespace App\Livewire\Tools;

use App\Actions\Tracking\ToggleHabitCompletionAction;
use App\Models\HabitDefinition;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BreathingEngine extends Component
{
    public string $mode = 'box'; // 'box' or 'sigh'
    public int $targetCycles = 4;
    public bool $isCompleted = false;

    public function setMode(string $mode): void
    {
        $this->mode = in_array($mode, ['box', 'sigh'], true) ? $mode : 'box';
        $this->isCompleted = false;
    }

    /**
     * Called by Alpine.js when the user completes the designated cycles.
     */
    public function logSessionCompletion(ToggleHabitCompletionAction $habitAction): void
    {
        /** @var User $user */
        $user = Auth::user();

        // Find or create the keystone Box Breathing habit definition
        $habit = HabitDefinition::firstOrCreate(
            ['title' => 'Box Breathing'],
            ['category' => 'somatic', 'is_system_preset' => true]
        );

        // Record the habit completion
        $habitAction->execute($user, $habit);

        $this->isCompleted = true;
    }

    public function render(): View
    {
        return view('livewire.tools.breathing-engine');
    }
}