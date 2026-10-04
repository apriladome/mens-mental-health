<?php

declare(strict_types=1);

namespace App\Livewire\Assessments;

use App\Actions\Clinical\ScoreAssessmentAction;
use App\Actions\Safety\MarkCrisisInterceptViewedAction;
use App\Actions\Safety\ResolveEmergencyHotlinesAction;
use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentSubmission;
use App\Models\CrisisEscalationLog;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TakeAssessment extends Component
{
    public Assessment $assessment;
    public Collection $questions;
    public int $currentIndex = 0;
    public array $answers = []; // [question_id => score]

    // Crisis Intercept State
    public bool $isCrisisTriggered = false;
    public Collection $emergencyHotlines;

    // Completion / Outcome State
    public bool $isCompleted = false;
    public ?AssessmentSubmission $submission = null;

    public function mount(ResolveEmergencyHotlinesAction $hotlinesAction): void
    {
        $this->assessment = Assessment::where('code', 'PHQ-9')
            ->where('is_active', true)
            ->firstOrFail();

        $this->questions = AssessmentQuestion::where('assessment_id', $this->assessment->id)
            ->orderBy('order', 'asc')
            ->get();

        $this->emergencyHotlines = $hotlinesAction->execute('US');
    }

    /**
     * Record answer for the current question and advance.
     */
    public function selectAnswer(int $questionId, int $value, ScoreAssessmentAction $scoreAction, MarkCrisisInterceptViewedAction $viewAction): void
    {
        $this->answers[$questionId] = $value;

        $currentQuestion = $this->questions->firstWhere('id', $questionId);

        // Immediate Safety Check on Question 9 (is_critical_flag)
        if ($currentQuestion && $currentQuestion->is_critical_flag && $value > 0) {
            $this->triggerCrisisIntercept($scoreAction, $viewAction);
            return;
        }

        // Advance to next question or complete
        if ($this->currentIndex < $this->questions->count() - 1) {
            $this->currentIndex++;
        } else {
            $this->finalizeSubmission($scoreAction);
        }
    }

    public function previousQuestion(): void
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }
    }

    /**
     * Triggered immediately if Question 9 > 0.
     */
    protected function triggerCrisisIntercept(ScoreAssessmentAction $scoreAction, MarkCrisisInterceptViewedAction $viewAction): void
    {
        /** @var User $user */
        $user = Auth::user();

        // 1. Execute clinical scoring action to record the acute submission and fire critical events
        $this->submission = $scoreAction->execute($user, $this->assessment, $this->answers);

        // 2. Locate the generated crisis escalation log and mark intercept viewed
        $latestLog = CrisisEscalationLog::where('user_id', $user->id)->latest()->first();
        if ($latestLog) {
            $viewAction->execute($latestLog);
        }

        $this->isCrisisTriggered = true;
    }

    /**
     * Normal completion when Question 9 is 0.
     */
    protected function finalizeSubmission(ScoreAssessmentAction $scoreAction): void
    {
        /** @var User $user */
        $user = Auth::user();

        $this->submission = $scoreAction->execute($user, $this->assessment, $this->answers);
        $this->isCompleted = true;
    }

    public function render(): View
    {
        return view('livewire.assessments.take-assessment', [
            'currentQuestion' => $this->questions[$this->currentIndex] ?? null,
            'totalQuestions' => $this->questions->count(),
        ]);
    }
}