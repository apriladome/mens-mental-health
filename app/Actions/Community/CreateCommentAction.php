<?php

declare(strict_types=1);

namespace App\Actions\Community;

use App\Models\CommunityComment;
use App\Models\CommunityPost;
use App\Models\CrisisEscalationLog;
use App\Models\ModerationReport;
use App\Models\User;
use App\Services\ContentSentinel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateCommentAction
{
    public function __construct(
        protected ContentSentinel $sentinel
    ) {}

    /**
     * Create a comment on a squad post with automated sentinel protection.
     */
    public function execute(User $user, CommunityPost $post, string $body): CommunityComment
    {
        $body = trim($body);

        if (mb_strlen($body) < 1) {
            throw ValidationException::withMessages([
                'body' => ['Comment cannot be empty.'],
            ]);
        }

        $inspection = $this->sentinel->inspect($body);

        return DB::transaction(function () use ($user, $post, $body, $inspection) {
            $comment = CommunityComment::create([
                'post_id' => $post->id,
                'user_id' => $user->id,
                'body' => $body,
                'is_quarantined' => $inspection['should_quarantine'],
            ]);

            if ($inspection['should_quarantine']) {
                ModerationReport::create([
                    'reporter_user_id' => null,
                    'reportable_type' => CommunityComment::class,
                    'reportable_id' => $comment->id,
                    'reason' => $inspection['flag_reason'] ?? 'other',
                    'status' => 'pending',
                ]);

                if ($inspection['verdict'] === 'self_harm') {
                    CrisisEscalationLog::create([
                        'user_id' => $user->id,
                        'trigger_source' => 'keyword_sentinel',
                        'severity_level' => 'imminent_danger',
                        'intercept_viewed' => false,
                        'clinician_dispatched_id' => null,
                        'resolved_at' => null,
                        'resolution_notes' => "Auto-quarantined squad comment #{$comment->id}. Matched trigger: '{$inspection['matched_keyword']}'",
                    ]);
                }
            }

            return $comment;
        });
    }
}