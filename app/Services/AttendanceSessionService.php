<?php

namespace App\Services;

use App\Models\AttendanceSession;
use App\Models\Prayer;
use Illuminate\Support\Carbon;

class AttendanceSessionService
{
    public function getOrCreateTodaySession(Prayer $prayer, ?Carbon $now = null): AttendanceSession
    {
        $now = $now ?: now();
        $date = $now->toDateString();

        $session = AttendanceSession::firstOrCreate(
            ['date' => $date, 'prayer_id' => $prayer->id],
            ['status' => 'live']
        );

        // Auto close kalau sekarang sudah lewat end_time
        $end = Carbon::createFromTimeString($prayer->end_time);
        $current = Carbon::createFromTimeString($now->format('H:i:s'));

        if ($session->status !== 'closed' && $current->greaterThan($end)) {
            $session->update([
                'status' => 'closed',
                'closed_at' => $now,
            ]);
        }

        return $session->fresh();
    }

    public function close(AttendanceSession $session): AttendanceSession
    {
        if ($session->status !== 'closed') {
            $session->update([
                'status' => 'closed',
                'closed_at' => now(),
            ]);
        }
        return $session->fresh();
    }

    public function isClosed(AttendanceSession $session): bool
    {
        return $session->status === 'closed';
    }
}
