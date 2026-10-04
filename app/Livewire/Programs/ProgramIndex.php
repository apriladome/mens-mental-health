<?php

declare(strict_types=1);

namespace App\Livewire\Programs;

use App\Models\Program;
use App\Models\User;
use App\Services\ProgramProgressTracker;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProgramIndex extends Component
{
    public Collection $programs;
    public array $progressMap = []; // [program_id => progressArray]

    public function mount(ProgramProgressTracker $tracker): void
    {
        /** @var User $user */
        $user = Auth::user();

        $this->programs = Program::where('is_published', true)
            ->with(['modules.lessons'])
            ->get();

        foreach ($this->programs as $program) {
            $this->progressMap[$program->id] = $tracker->getProgress($user, $program);
        }
    }

    public function render(): View
    {
        return view('livewire.programs.program-index');
    }
}