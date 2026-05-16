<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            [
                'name' => 'Kegiatan Pra KBM',
                'type' => 'routine',
                'days' => [1, 2, 3, 4, 5, 6],
                'event_date' => null,
                'order' => 1,
                'start_time' => '07:00:00',
                'end_time' => '07:30:00',
                'late_minutes' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Kegiatan Muhadharah',
                'type' => 'routine',
                'days' => [3],
                'event_date' => null,
                'order' => 2,
                'start_time' => '20:00:00',
                'end_time' => '21:30:00',
                'late_minutes' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Kegiatan Sima’an Bil Ghaib',
                'type' => 'routine',
                'days' => [6],
                'event_date' => null,
                'order' => 3,
                'start_time' => '20:00:00',
                'end_time' => '21:30:00',
                'late_minutes' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Absen Dadakan',
                'type' => 'manual',
                'days' => null,
                'event_date' => null,
                'order' => 4,
                'start_time' => '00:00:00',
                'end_time' => '00:00:00',
                'late_minutes' => 0,
                'is_active' => false,
            ],
            [
                'name' => 'Check In Kedatangan Santri',
                'type' => 'manual',
                'days' => null,
                'event_date' => null,
                'order' => 5,
                'start_time' => '00:00:00',
                'end_time' => '00:00:00',
                'late_minutes' => 0,
                'is_active' => false,
            ],
            [
                'name' => 'Check Out Perpulangan Santri',
                'type' => 'manual',
                'days' => null,
                'event_date' => null,
                'order' => 6,
                'start_time' => '00:00:00',
                'end_time' => '00:00:00',
                'late_minutes' => 0,
                'is_active' => false,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::updateOrCreate(
                ['name' => $activity['name']],
                $activity
            );
        }
    }
}