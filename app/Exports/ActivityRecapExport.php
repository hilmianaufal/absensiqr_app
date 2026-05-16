<?php

namespace App\Exports;

use App\Models\ActivityAttendance;
use App\Models\ActivitySession;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityRecapExport implements FromArray, WithHeadings
{
    public function __construct(
        public string $date,
        public int $activityId,
        public string $activityName,
        public ?string $kelas = null,
        public ?string $kamar = null,
    ) {}

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kegiatan',
            'NIS',
            'Nama',
            'Kelas',
            'Kamar',
            'Status',
            'Jam Scan',
        ];
    }

    public function array(): array
    {
        $session = ActivitySession::where('activity_id', $this->activityId)
            ->whereDate('started_at', $this->date)
            ->first();

        $rows = [];

        $studentsQuery = Student::query()
            ->where('is_active', true)
            ->when($this->kelas, fn ($q) => $q->where('kelas', $this->kelas))
            ->when($this->kamar, fn ($q) => $q->where('kamar', $this->kamar));

        if (!$session) {
            foreach ($studentsQuery->orderBy('name')->get() as $s) {
                $rows[] = [
                    $this->date,
                    $this->activityName,
                    $s->nis,
                    $s->name,
                    $s->kelas ?? '-',
                    $s->kamar ?? '-',
                    'belum',
                    null,
                ];
            }

            return $rows;
        }

        $attendances = ActivityAttendance::with('student')
            ->where('activity_session_id', $session->id)
            ->when($this->kelas, fn ($q) => $q->whereHas('student', fn ($s) => $s->where('kelas', $this->kelas)))
            ->when($this->kamar, fn ($q) => $q->whereHas('student', fn ($s) => $s->where('kamar', $this->kamar)))
            ->orderBy('scanned_at')
            ->get();

        foreach ($attendances as $a) {
            $rows[] = [
                $this->date,
                $this->activityName,
                $a->student->nis,
                $a->student->name,
                $a->student->kelas ?? '-',
                $a->student->kamar ?? '-',
                $a->status,
                optional($a->scanned_at)->format('H:i:s'),
            ];
        }

        $presentIds = $attendances->pluck('student_id');

        foreach ((clone $studentsQuery)->whereNotIn('id', $presentIds)->orderBy('name')->get() as $s) {
            $rows[] = [
                $this->date,
                $this->activityName,
                $s->nis,
                $s->name,
                $s->kelas ?? '-',
                $s->kamar ?? '-',
                'belum',
                null,
            ];
        }

        return $rows;
    }
}