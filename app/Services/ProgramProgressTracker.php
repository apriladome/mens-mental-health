<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Lesson;
use App\Models\Program;
use App\Models\User;
use App\Models\UserProgramProgress;

class ProgramProgressTracker
{
    /**
     * Compute completion metrics and the next actionable lesson for a user in a program.
     *
     * @return array{
     *     status: string,
     *     total_lessons: int,
     *     completed_lessons_count: int,
     *     completion_percentage: int,
     *     next_lesson: ?Lesson,
     *     is_completed: bool
     * }
     */
    public function getProgress(User $user, Program $program): array
    {
        // 1. Fetch all lessons ordered by module order and lesson order
        $allLessons = Lesson::whereHas('module', function ($query) use ($program) {
            $query->where('program_id', $program->id);
        })
        ->join('modules', 'lessons.module_id', '=', 'modules.id')
        ->orderBy('modules.order', 'asc')
        ->orderBy('lessons.order', 'asc')
        ->select('lessons.*')
        ->get();

        $totalLessons = $allLessons->count();
        if ($totalLessons === 0) {
            return [
                'status' => 'empty',
                'total_lessons' => 0,
                'completed_lessons_count' => 0,
                'completion_percentage' => 0,
                'next_lesson' => null,
                'is_completed' => false,
            ];
        }

        // 2. Fetch user's progress record
        $progress = UserProgramProgress::where('user_id', $user->id)
            ->where('program_id', $program->id)
            ->first();

        if (!$progress || !$progress->last_completed_lesson_id) {
            return [
                'status' => $progress ? $progress->status : 'not_started',
                'total_lessons' => $totalLessons,
                'completed_lessons_count' => 0,
                'completion_percentage' => 0,
                'next_lesson' => $allLessons->first(),
                'is_completed' => false,
            ];
        }

        // 3. Find index of last completed lesson
        $lastCompletedIndex = $allLessons->search(fn ($l) => $l->id === $progress->last_completed_lesson_id);

        if ($lastCompletedIndex === false) {
            $completedCount = 0;
            $nextLesson = $allLessons->first();
        } else {
            $completedCount = $lastCompletedIndex + 1;
            $nextLesson = $allLessons->get($completedCount); // Next sequential item or null if finished
        }

        $percentage = (int) round(($completedCount / $totalLessons) * 100);
        $isCompleted = $progress->status === 'completed' || $completedCount >= $totalLessons;

        return [
            'status' => $progress->status,
            'total_lessons' => $totalLessons,
            'completed_lessons_count' => $completedCount,
            'completion_percentage' => min(100, $percentage),
            'next_lesson' => $nextLesson,
            'is_completed' => $isCompleted,
        ];
    }
}