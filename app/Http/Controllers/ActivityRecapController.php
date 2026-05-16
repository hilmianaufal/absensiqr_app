<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityAttendance;
use App\Models\ActivitySession;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ActivityRecapController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $activityId = $request->input('activity_id');

        $activities = Activity::orderBy('order')->get();
        $selectedActivity = $activityId
            ? Activity::find($activityId)
            : $activities->first();

        $session = null;
        $attendances = collect();
        $absentStudents = collect();

        if ($selectedActivity) {
            $session = ActivitySession::where('activity_id', $selectedActivity->id)
                ->whereDate('started_at', $date)
                ->first();

            if ($session) {
                $attendances = ActivityAttendance::with('student')
                    ->where('activity_session_id', $session->id)
                    ->orderByDesc('scanned_at')
                    ->get();

                $presentIds = $attendances->pluck('student_id');

                $absentStudents = Student::where('is_active', true)
                    ->whereNotIn('id', $presentIds)
                    ->orderBy('name')
                    ->get();
            }
        }

        $totalStudents = Student::where('is_active', true)->count();
        $hadirCount = $attendances->where('status', 'hadir')->count();
        $terlambatCount = $attendances->where('status', 'terlambat')->count();
        $belumCount = max(0, $totalStudents - ($hadirCount + $terlambatCount));

        return view('activities.recap', compact(
            'date',
            'activities',
            'selectedActivity',
            'session',
            'attendances',
            'absentStudents',
            'totalStudents',
            'hadirCount',
            'terlambatCount',
            'belumCount'
        ));
    }
}