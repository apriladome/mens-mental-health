<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\AssessmentSubmission;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CriticalAssessmentScoreReached
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param array<string, mixed> $triggerMetadata
     */
    public function __construct(
        public User $user,
        public AssessmentSubmission $submission,
        public array $triggerMetadata = []
    ) {}
}