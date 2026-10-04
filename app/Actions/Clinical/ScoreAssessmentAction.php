<?php

declare(strict_types=1);

namespace App\Actions\Clinical;

use App\Enums\RiskClassification;
use App\Events\CriticalAssessmentScoreReached;
use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentSubmission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ScoreAssessmentAction
{
    /**
     * @param array<int, int> $answers Key-value map of [question_id => selected_value]
     */
    public function execute(User $user, Assessment $assessment, array $answers): AssessmentSubmission
    {
        $questions = AssessmentQuestion::where('assessment_id', $assessment->id)
            ->get()
            ->keyBy('id');

        if ($questions->isEmpty()) {
            throw new InvalidArgumentException("Assessment #{$assessment->id} has no defined questions.");
        }

        return DB::transaction(function () use ($user, $assessment, $answers, $questions) {
            $totalScore = 0;
            $hasCriticalTrigger = false;
            $criticalQuestionsReported = [];

            // 1. Create base submission record
            $submission = AssessmentSubmission::create([
                'user_id' => $user->id,
                'assessment_id' => $assessment->id,
                'total_score' => 0,
                'risk_classification' => RiskClassification::LOW->value,
                'completed_at' => Carbon::now(),
            ]);

            // 2. Save individual answers and check weights
            foreach ($questions as $questionId => $question) {
                $selectedValue = (int) ($answers[$questionId] ?? 0);
                $totalScore += $selectedValue;

                AssessmentAnswer::create([
                    'submission_id' => $submission->id,
                    'question_id' => $questionId,
                    'selected_value' => $selectedValue,
                ]);

                if ($question->is_critical_flag && $selectedValue > 0) {
                    $hasCriticalTrigger = true;
                    $criticalQuestionsReported[] = [
                        'question_id' => $questionId,
                        'selected_value' => $selectedValue,
                    ];
                }
            }

            // 3. Classify clinical risk
            $classification = match ($assessment->code) {
                'PHQ-9' => RiskClassification::fromPhq9Score($totalScore),
                default => ($totalScore > 10 ? RiskClassification::MODERATE : RiskClassification::LOW),
            };

            // If a critical question was flagged, enforce minimum classification of ACUTE
            if ($hasCriticalTrigger) {
                $classification = RiskClassification::ACUTE;
            }

            // 4. Update submission
            $submission->update([
                'total_score' => $totalScore,
                'risk_classification' => $classification->value,
            ]);

            // 5. Fire critical alert event
            if ($hasCriticalTrigger) {
                CriticalAssessmentScoreReached::dispatch(
                    $user,
                    $submission,
                    [
                        'trigger_source' => 'phq9_q9',
                        'severity_level' => 'imminent_danger',
                        'critical_answers' => $criticalQuestionsReported,
                        'total_score' => $totalScore,
                    ]
                );
            }

            return $submission->fresh(['answers', 'assessment']);
        });
    }
}