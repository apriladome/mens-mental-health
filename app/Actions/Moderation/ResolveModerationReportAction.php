<?php

declare(strict_types=1);

namespace App\Actions\Moderation;

use App\Models\CommunityComment;
use App\Models\CommunityPost;
use App\Models\ModerationAction;
use App\Models\ModerationReport;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ResolveModerationReportAction
{
    /**
     * Resolve a pending moderation report and log the moderator's decision.
     *
     * @param 'warning_issued'|'content_scrubbed'|'user_suspended'|'dismissed' $action
     */
    public function execute(
        User $moderator,
        ModerationReport $report,
        string $action,
        ?string $notes = null
    ): ModerationReport {
        $validActions = ['warning_issued', 'content_scrubbed', 'user_suspended', 'dismissed'];

        if (!in_array($action, $validActions, true)) {
            throw new InvalidArgumentException("Invalid moderation action: {$action}");
        }

        return DB::transaction(function () use ($moderator, $report, $action, $notes) {
            $content = $report->reportable_type::find($report->reportable_id);

            if ($content) {
                if ($action === 'content_scrubbed') {
                    $content->delete(); // Soft-delete post or comment
                } elseif ($action === 'dismissed') {
                    // False alarm: restore content to public view
                    $content->is_quarantined = false;
                    $content->save();
                }
            }

            // Record moderator action
            ModerationAction::create([
                'report_id' => $report->id,
                'moderator_user_id' => $moderator->id,
                'action_taken' => $action,
                'notes' => $notes,
            ]);

            // Update report status
            $report->update([
                'status' => $action === 'dismissed' ? 'dismissed' : 'actioned',
            ]);

            return $report->fresh(['actions']);
        });
    }
}