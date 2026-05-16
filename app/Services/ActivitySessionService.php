<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\ActivitySession;
use Illuminate\Support\Carbon;

class ActivitySessionService
{
    public function getOrCreateCurrentSession(Activity $activity): ActivitySession
    {
        $today = Carbon::today()->toDateString();

        $startedAt = Carbon::parse($today . ' ' . $activity->start_time);
        $endedAt   = Carbon::parse($today . ' ' . $activity->end_time);

        return ActivitySession::firstOrCreate(
            [
                'activity_id' => $activity->id,
                'started_at' => $startedAt,
            ],
            [
                'ended_at' => $endedAt,
                'status' => 'live',
            ]
        );
    }
}