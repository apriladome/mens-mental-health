<?php

declare(strict_types=1);

namespace App\Actions\Safety;

use App\Models\CrisisEscalationLog;
use Carbon\Carbon;

class MarkCrisisInterceptViewedAction
{
    /**
     * Mark that the user was shown the emergency de-escalation intercept.
     */
    public function execute(CrisisEscalationLog $log): CrisisEscalationLog
    {
        if (!$log->intercept_viewed) {
            $log->update([
                'intercept_viewed' => true,
                'updated_at' => Carbon::now(),
            ]);
        }

        return $log->fresh();
    }
}