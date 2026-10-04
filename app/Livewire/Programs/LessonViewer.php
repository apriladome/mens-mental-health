<?php

declare(strict_types=1);

namespace App\Livewire\Programs;

use App\Actions\Content\CompleteLessonAction;
use App\Models\Lesson;
use App\Models\User;
use App\Services\ProgramProgressTracker;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LessonViewer extends Component
{
    public Lesson $lesson;
    public array $progressStats = [];

    public function mount(string $slug, ProgramProgressTracker $tracker): void
    {
        $this->lesson = Lesson::where('slug', $slug)
            ->with(['module.program.modules.lessons'])
            ->firstOrFail();

        /** @var User $user */
        $user = Auth::user();

        $this->progressStats = $tracker->getProgress($user, $this->lesson->module->program);
    }

    public function completeAndAdvance(CompleteLessonAction $completeAction): void
    {
        /** @var User $user */
        $user = Auth::user();

        // 1. Mark current lesson completed
        $completeAction->execute($user, $this->lesson);

        // 2. Fetch updated progress to find next lesson
        $tracker = app(ProgramProgressTracker::class);
        $updatedStats = $tracker->getProgress($user, $this->lesson->module->program);

        if ($updatedStats['next_lesson']) {
            $this->redirect(route('programs.lesson', ['slug' => $updatedStats['next_lesson']->slug]), navigate: true);
        } else {
            $this->redirect(route('programs.index'), navigate: true);
        }
    }

    public function render(): View
    {
        return view('livewire.programs.lesson-viewer');
    }
}