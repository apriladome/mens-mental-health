<?php

declare(strict_types=1);

namespace App\Livewire\Onboarding;

use App\Actions\Tracking\LogDailyReadinessAction;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class IntakeWizard extends Component
{
    public int $step = 1;
    public int $totalSteps = 3;

    // Step 1: Energy Drain Vectors
    public array $selectedStrains = [];

    // Step 2: Immediate Somatic Readiness
    public int $energyLevel = 5;
    public int $irritabilityLevel = 5;
    public int $focusLevel = 5;
    public int $sleepQuality = 5;

    // Step 3: Identity Setup
    public string $publicHandle = '';

    protected array $suggestedHandles = [
        'IronPath', 'FieldOps', 'TimberWolf', 'RidgeLine', 
        'ApexPoint', 'NorthStar', 'DeltaEcho', 'StoneForge',
        'Vanguard', 'SilentOak', 'ColdStream', 'BravoLead'
    ];

    public function mount(): void
    {
        /** @var User|null $user */
        $user = Auth::user();

        if ($user && $user->profile) {
            $this->publicHandle = $user->profile->public_handle;
        } else {
            $this->generateHandle();
        }
    }

    public function toggleStrain(string $strain): void
    {
        if (in_array($strain, $this->selectedStrains, true)) {
            $this->selectedStrains = array_diff($this->selectedStrains, [$strain]);
        } else {
            $this->selectedStrains[] = $strain;
        }
    }

    public function generateHandle(): void
    {
        $prefix = $this->suggestedHandles[array_rand($this->suggestedHandles)];
        $number = random_int(10, 99);
        $this->publicHandle = "{$prefix}_{$number}";
    }

    public function nextStep(): void
    {
        if ($this->step === 1 && empty($this->selectedStrains)) {
            $this->addError('selectedStrains', 'Please select at least one operational area you want to stabilize.');
            return;
        }

        $this->resetErrorBag();
        $this->step++;
    }

    public function previousStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function completeIntake(LogDailyReadinessAction $logReadiness): void
    {
        $this->validate([
            'publicHandle' => ['required', 'string', 'min:3', 'max:30', 'regex:/^[a-zA-Z0-9_]+$/'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        // 1. Update Profile Handle
        if ($user->profile) {
            $user->profile->update([
                'public_handle' => $this->publicHandle,
            ]);
        }

        // 2. Log baseline readiness
        $logReadiness->execute($user, [
            'energy_level' => $this->energyLevel,
            'irritability_level' => $this->irritabilityLevel,
            'focus_level' => $this->focusLevel,
            'sleep_quality' => $this->sleepQuality,
        ]);

        session()->flash('intake_completed', 'Operational baseline established. Welcome to the platform.');

        $this->redirect('/', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.onboarding.intake-wizard');
    }
}