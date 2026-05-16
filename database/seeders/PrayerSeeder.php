<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prayer;

class PrayerSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name'=>'Subuh',   'order'=>1, 'start_time'=>'04:20', 'end_time'=>'04:45', 'late_minutes'=>10, 'is_active'=>true],
            ['name'=>'Dzuhur',  'order'=>2, 'start_time'=>'12:05', 'end_time'=>'12:30', 'late_minutes'=>10, 'is_active'=>true],
            ['name'=>'Ashar',   'order'=>3, 'start_time'=>'15:10', 'end_time'=>'15:35', 'late_minutes'=>10, 'is_active'=>true],
            ['name'=>'Maghrib', 'order'=>4, 'start_time'=>'18:10', 'end_time'=>'18:30', 'late_minutes'=>5,  'is_active'=>true],
            ['name'=>'Isya',    'order'=>5, 'start_time'=>'19:40', 'end_time'=>'20:05', 'late_minutes'=>5,  'is_active'=>true],
        ];

        foreach ($data as $p) {
            Prayer::updateOrCreate(['name' => $p['name']], $p);
        }
    }
}

