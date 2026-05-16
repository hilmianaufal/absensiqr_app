<?php

namespace App\Http\Controllers;

use App\Models\Prayer;
use Illuminate\Http\Request;

class PrayerController extends Controller
{
    public function index()
    {
        $prayers = Prayer::orderBy('order')->get();
        return view('prayers.index', compact('prayers'));
    }

    public function edit(Prayer $prayer)
    {
        return view('prayers.edit', compact('prayer'));
    }

    public function update(Request $request, Prayer $prayer)
    {
        $data = $request->validate([
            'start_time' => ['required'], // HH:MM
            'end_time' => ['required'],   // HH:MM
            'late_minutes' => ['required','integer','min:0','max:180'],
            'is_active' => ['nullable'],
        ]);

        // HTML time input biasanya "HH:MM", kita simpan jadi "HH:MM:00"
        $start = strlen($data['start_time']) === 5 ? $data['start_time'].':00' : $data['start_time'];
        $end   = strlen($data['end_time']) === 5 ? $data['end_time'].':00' : $data['end_time'];

        $prayer->update([
            'start_time' => $start,
            'end_time' => $end,
            'late_minutes' => (int) $data['late_minutes'],
            'is_active' => (bool) ($request->input('is_active') ?? false),
        ]);

        return redirect()->route('prayers.index')->with('success', 'Jadwal sholat diperbarui.');
    }
} 