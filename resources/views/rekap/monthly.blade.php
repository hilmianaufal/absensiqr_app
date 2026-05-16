@extends('layouts.app')
@section('title','Rekap Bulanan')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
  <div>
    <h5 class="fw-semibold mb-0">Rekap Bulanan per Santri</h5>
    <div class="text-muted small">
      Periode: {{ $start }} s/d {{ $end }} • {{ $daysInMonth }} hari • {{ $prayerCount }} sholat/hari
    </div>
  </div>
  <a href="{{ route('rekap.index') }}" class="btn btn-outline-primary btn-sm">Rekap Harian</a>
  <div class="d-flex gap-2">
  <a href="{{ route('rekap.monthly.export.excel', request()->query()) }}" class="btn btn-outline-success btn-sm">
    Export Excel
  </a>
  <a href="{{ route('rekap.monthly.export.pdf', request()->query()) }}" class="btn btn-outline-danger btn-sm">
    Export PDF
  </a>
</div>
</div>


<form class="card p-3 mb-3" method="GET">
  <div class="row g-2 align-items-end">
    <div class="col-6 col-md-3">
      <label class="form-label small mb-1">Bulan</label>
      <input type="month" name="month" value="{{ $month }}" class="form-control form-control-sm">
    </div>

    <div class="col-6 col-md-3">
      <label class="form-label small mb-1">Kelas</label>
      <select name="kelas" class="form-select form-select-sm">
        <option value="">Semua</option>
        @foreach($kelasList as $k)
          <option value="{{ $k }}" @selected($kelas===$k)>{{ $k }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-6 col-md-3">
      <label class="form-label small mb-1">Kamar</label>
      <select name="kamar" class="form-select form-select-sm">
        <option value="">Semua</option>
        @foreach($kamarList as $km)
          <option value="{{ $km }}" @selected($kamar===$km)>{{ $km }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-12 col-md-3 d-grid">
      <button class="btn btn-primary btn-sm">Terapkan</button>
    </div>
  </div>
</form>

{{-- Ringkasan --}}
<div class="row g-2 mb-3">
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Total Santri</div>
      <div class="fw-semibold">{{ $totalStudents }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Total Scan</div>
      <div class="fw-semibold">{{ $globalScan }}</div>
      <div class="text-muted" style="font-size:12px;">Expected: {{ $globalExpected }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Hadir</div>
      <div class="fw-semibold text-success">{{ $globalHadir }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Terlambat</div>
      <div class="fw-semibold text-warning">{{ $globalTelat }}</div>
      <div class="text-muted" style="font-size:12px;">Belum: {{ $globalBelum }}</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header bg-white py-2">
    <span class="fw-semibold small">Daftar Santri</span>
    <span class="text-muted small">• Expected per santri: {{ $expectedPerStudent }}</span>
  </div>

  <div class="table-responsive">
    <table class="table table-sm align-middle mb-0 small">
      <thead class="table-light">
        <tr>
          <th style="width:90px;">NIS</th>
          <th>Nama</th>
          <th style="width:70px;">Hadir</th>
          <th style="width:70px;">Telat</th>
          <th style="width:80px;">Scan</th>
          <th style="width:90px;">Belum</th>
          <th class="text-end" style="width:90px;">%</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rows as $r)
          @php
            $belum = max(0, $expectedPerStudent - (int)$r->total_scan);
            $pct = $expectedPerStudent > 0 ? round(((int)$r->total_scan / $expectedPerStudent) * 100) : 0;
          @endphp
          <tr>
            <td class="fw-semibold">{{ $r->nis }}</td>
            <td>
              <div class="fw-semibold">{{ $r->name }}</div>
              <div class="text-muted" style="font-size:12px;">
                {{ $r->kelas ?? '-' }} • {{ $r->kamar ?? '-' }}
              </div>
            </td>
            <td class="text-success fw-semibold">{{ $r->hadir }}</td>
            <td class="text-warning fw-semibold">{{ $r->terlambat }}</td>
            <td class="fw-semibold">{{ $r->total_scan }}</td>
            <td class="text-danger fw-semibold">{{ $belum }}</td>
            <td class="text-end fw-semibold">{{ $pct }}%</td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center text-muted py-3">Belum ada data.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="card-footer py-2">
    {{ $rows->links() }}
  </div>
</div>
@endsection
