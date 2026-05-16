<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Prayer;
use App\Models\Student;
use App\Services\PrayerTimeService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, PrayerTimeService $prayerService)
    {
        $today = now()->toDateString();

        $prayers = Prayer::where('is_active', true)->orderBy('order')->get();
        $activePrayer = $prayerService->getActivePrayer();

        $totalStudents = Student::where('is_active', true)->count();

        // Siapkan data ringkasan per sholat
        $items = $prayers->map(function ($p) use ($today, $totalStudents, $prayerService) {
            $session = AttendanceSession::firstOrCreate(
                ['date' => $today, 'prayer_id' => $p->id],
                ['status' => 'live']
            );

            $hadir = Attendance::where('attendance_session_id', $session->id)
                ->where('status', 'hadir')
                ->count();

            $telat = Attendance::where('attendance_session_id', $session->id)
                ->where('status', 'terlambat')
                ->count();

            $sudah = $hadir + $telat;
            $belum = max(0, $totalStudents - $sudah);

            return [
                'prayer' => $p,
                'session' => $session,
                'status' => $prayerService->getPrayerStatus($p), // soon/live/closed
                'hadir' => $hadir,
                'telat' => $telat,
                'belum' => $belum,
                'progress' => $totalStudents > 0 ? (int) round(($sudah / $totalStudents) * 100) : 0,
            ];
        });

        return view('dashboard', compact(
            'today',
            'prayers',
            'activePrayer',
            'totalStudents',
            'items'
        ));
    }
}
