<?php

declare(strict_types=1);

namespace App\Actions\Moderation;

use App\Models\CommunityComment;
use App\Models\CommunityPost;
use InvalidArgumentException;

class QuarantineContentAction
{
    /**
     * Quarantine a post or comment.
     */
    public function execute(CommunityPost|CommunityComment $content): bool
    {
        $content->is_quarantined = true;
        return $content->save();
    }
}