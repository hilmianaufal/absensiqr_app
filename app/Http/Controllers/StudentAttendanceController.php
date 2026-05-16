<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Prayer;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StudentAttendanceController extends Controller
{
    public function show(Request $request, Student $student)
    {
        $month = $request->input('month', now()->format('Y-m'));

        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end   = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $prayers = Prayer::where('is_active', true)->orderBy('order')->get();

        // Ambil absensi santri pada bulan tsb (join session untuk ambil date & prayer)
        $att = Attendance::query()
            ->join('attendance_sessions', 'attendance_sessions.id', '=', 'attendances.attendance_session_id')
            ->join('prayers', 'prayers.id', '=', 'attendance_sessions.prayer_id')
            ->where('attendances.student_id', $student->id)
            ->whereBetween('attendance_sessions.date', [$start->toDateString(), $end->toDateString()])
            ->select([
                'attendance_sessions.date as date',
                'attendance_sessions.prayer_id as prayer_id',
                'attendances.status as status',
                'attendances.scanned_at as scanned_at',
            ])
            ->get();

        // Map: [date][prayer_id] => status
        $map = [];
        foreach ($att as $row) {
            $d = Carbon::parse($row->date)->toDateString();
            $map[$d][$row->prayer_id] = [
                'status' => $row->status,
                'time' => Carbon::parse($row->scanned_at)->format('H:i'),
            ];
        }

        // Generate list tanggal bulan tsb
        $dates = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $dates[] = $cursor->toDateString();
            $cursor->addDay();
        }

        // Summary
        $hadir = $att->where('status','hadir')->count();
        $telat = $att->where('status','terlambat')->count();

        $expected = count($dates) * max(1, $prayers->count());
        $scanTotal = $hadir + $telat;
        $belum = max(0, $expected - $scanTotal);

        return view('students.attendance', compact(
            'student','month','start','end','dates','prayers','map',
            'hadir','telat','belum','expected','scanTotal'
        ));
    }
}
