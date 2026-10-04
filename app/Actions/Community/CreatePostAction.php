<?php

declare(strict_types=1);

namespace App\Actions\Community;

use App\Models\CommunityGroup;
use App\Models\CommunityPost;
use App\Models\CrisisEscalationLog;
use App\Models\ModerationReport;
use App\Models\User;
use App\Services\ContentSentinel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreatePostAction
{
    public function __construct(
        protected ContentSentinel $sentinel
    ) {}

    /**
     * Create a community squad post with real-time safety inspection.
     */
    public function execute(User $user, CommunityGroup $group, string $body): CommunityPost
    {
        $body = trim($body);

        if (mb_strlen($body) < 3) {
            throw ValidationException::withMessages([
                'body' => ['Post must be at least 3 characters long.'],
            ]);
        }

        $inspection = $this->sentinel->inspect($body);

        return DB::transaction(function () use ($user, $group, $body, $inspection) {
            $post = CommunityPost::create([
                'group_id' => $group->id,
                'user_id' => $user->id,
                'body' => $body,
                'is_quarantined' => $inspection['should_quarantine'],
            ]);

            // If flagged by sentinel, route to moderation queue
            if ($inspection['should_quarantine']) {
                ModerationReport::create([
                    'reporter_user_id' => null, // System-generated
                    'reportable_type' => CommunityPost::class,
                    'reportable_id' => $post->id,
                    'reason' => $inspection['flag_reason'] ?? 'other',
                    'status' => 'pending',
                ]);

                // If flagged for self-harm, trigger crisis escalation log
                if ($inspection['verdict'] === 'self_harm') {
                    CrisisEscalationLog::create([
                        'user_id' => $user->id,
                        'trigger_source' => 'keyword_sentinel',
                        'severity_level' => 'imminent_danger',
                        'intercept_viewed' => false,
                        'clinician_dispatched_id' => null,
                        'resolved_at' => null,
                        'resolution_notes' => "Auto-quarantined squad post #{$post->id}. Matched trigger: '{$inspection['matched_keyword']}'",
                    ]);
                }
            }

            return $post;
        });
    }
}