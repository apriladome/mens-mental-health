<?php

declare(strict_types=1);

namespace App\Actions\Content;

use App\Models\Program;
use App\Models\User;
use App\Models\UserProgramProgress;
use Illuminate\Validation\ValidationException;

class EnrollUserInProgramAction
{
    /**
     * Enroll a user into a program or return their existing active progress.
     */
    public function execute(User $user, Program $program): UserProgramProgress
    {
        if (!$program->is_published) {
            throw ValidationException::withMessages([
                'program' => ['This operational track is currently in development and not yet open for enrollment.'],
            ]);
        }

        return UserProgramProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'program_id' => $program->id,
            ],
            [
                'last_completed_lesson_id' => null,
                'status' => 'in_progress',
                'completed_at' => null,
            ]
        );
    }
}