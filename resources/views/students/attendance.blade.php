@extends('layouts.app')
@section('title','Detail Absensi Santri')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
  <div>
    <h5 class="fw-semibold mb-0">Detail Absensi</h5>
    <div class="text-muted small">
      {{ $student->name }} • {{ $student->nis }} • {{ $month }}
    </div>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('students.show', $student) }}" class="btn btn-light btn-sm">Profil</a>
    <a href="{{ route('rekap.monthly', ['month'=>$month]) }}" class="btn btn-outline-primary btn-sm">Rekap Bulanan</a>
  </div>
</div>

<form class="card p-3 mb-3" method="GET">
  <div class="row g-2 align-items-end">
    <div class="col-6 col-md-3">
      <label class="form-label small mb-1">Bulan</label>
      <input type="month" name="month" value="{{ $month }}" class="form-control form-control-sm">
    </div>
    <div class="col-6 col-md-3 d-grid">
      <button class="btn btn-primary btn-sm">Terapkan</button>
    </div>
  </div>
</form>

{{-- Ringkasan --}}
<div class="row g-2 mb-3">
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Expected</div>
      <div class="fw-semibold">{{ $expected }}</div>
      <div class="text-muted" style="font-size:12px;">({{ count($dates) }} hari × {{ $prayers->count() }} sholat)</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Total Scan</div>
      <div class="fw-semibold">{{ $scanTotal }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Hadir</div>
      <div class="fw-semibold text-success">{{ $hadir }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Terlambat</div>
      <div class="fw-semibold text-warning">{{ $telat }}</div>
      <div class="text-muted" style="font-size:12px;">Belum: {{ $belum }}</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
    <span class="fw-semibold small">Kalender Absensi</span>
    <span class="text-muted small">H=Hadir • T=Telat • -=Belum</span>
  </div>

  <div class="table-responsive">
    <table class="table table-sm align-middle mb-0 small">
      <thead class="table-light">
        <tr>
          <th style="width:120px;">Tanggal</th>
          @foreach($prayers as $p)
            <th class="text-center" style="min-width:70px;">{{ $p->name }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach($dates as $d)
          @php
            $carbon = \Illuminate\Support\Carbon::parse($d);
            $isFriday = $carbon->dayOfWeek === 5;
            $isSunday = $carbon->dayOfWeek === 0;
          @endphp
          <tr @class(['table-warning' => $isFriday, 'table-light' => $isSunday])>
            <td class="fw-semibold">
              {{ $carbon->format('d M') }}
              <div class="text-muted" style="font-size:12px;">{{ $carbon->translatedFormat('l') }}</div>
            </td>

            @foreach($prayers as $p)
              @php
                $cell = $map[$d][$p->id] ?? null;
              @endphp
              <td class="text-center">
                @if(!$cell)
                  <span class="text-muted">-</span>
                @else
                  @if($cell['status'] === 'hadir')
                    <span class="badge bg-success-subtle text-success">H</span>
                  @else
                    <span class="badge bg-warning-subtle text-warning-emphasis">T</span>
                  @endif
                  <div class="text-muted" style="font-size:11px;">{{ $cell['time'] }}</div>
                @endif
              </td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
