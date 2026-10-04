<?php

declare(strict_types=1);

namespace App\Actions\Content;

use App\Models\Lesson;
use App\Models\Program;
use App\Models\User;
use App\Models\UserProgramProgress;
use App\Services\ProgramProgressTracker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CompleteLessonAction
{
    public function __construct(
        protected ProgramProgressTracker $tracker
    ) {}

    /**
     * Mark a lesson completed and advance the user's track standing.
     */
    public function execute(User $user, Lesson $lesson): UserProgramProgress
    {
        /** @var Program $program */
        $program = $lesson->module->program;

        return DB::transaction(function () use ($user, $program, $lesson) {
            $progress = UserProgramProgress::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'program_id' => $program->id,
                ],
                [
                    'status' => 'in_progress',
                ]
            );

            // Update to this lesson
            $progress->update([
                'last_completed_lesson_id' => $lesson->id,
            ]);

            // Re-calculate completion metrics
            $metrics = $this->tracker->getProgress($user, $program);

            if ($metrics['is_completed'] && $progress->status !== 'completed') {
                $progress->update([
                    'status' => 'completed',
                    'completed_at' => Carbon::now(),
                ]);
            }

          return $progress->fresh(); 
        });
    }
}