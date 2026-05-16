@extends('layouts.app')
@section('title','Dashboard')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
  <div>
    <h5 class="fw-semibold mb-0">Dashboard</h5>
    <div class="text-muted small">Ringkasan absensi hari ini • {{ $today }}</div>
  </div>
</div>

{{-- MENU BUBBLE (4 kolom per baris) --}}
<div class="menu-bubble-wrap mb-3">
  <div class="menu-bubble-title">Menu</div>

  <div class="menu-bubble-card">
    <div class="menu-bubble-grid">

      @can('scan_qr')
      <a href="{{ route('scan.index') }}" class="menu-bubble-item">
        <div class="menu-bubble-icon ic-success"><i class="bi bi-qr-code-scan"></i></div>
        <div class="menu-bubble-label">Scan</div>
      </a>
      @endcan

    @can('scan_qr')
    <a href="{{ route('activities.scan') }}" class="menu-bubble-item">
      <div class="menu-bubble-icon ic-success"><i class="bi bi-qr-code"></i></div>
      <div class="menu-bubble-label">Scan Kegiatan</div>
    </a>
    @endcan

      @can('manage_students')
      <a href="{{ route('students.index') }}" class="menu-bubble-item">
        <div class="menu-bubble-icon ic-warning"><i class="bi bi-people"></i></div>
        <div class="menu-bubble-label">Santri</div>
      </a>
      @endcan

      @can('view_reports')
      <a href="{{ route('rekap.index') }}" class="menu-bubble-item">
        <div class="menu-bubble-icon ic-primary"><i class="bi bi-clipboard-data"></i></div>
        <div class="menu-bubble-label">Rekap</div>
      </a>

      <a href="{{ route('rekap.monthly') }}" class="menu-bubble-item">
        <div class="menu-bubble-icon ic-info"><i class="bi bi-calendar3"></i></div>
        <div class="menu-bubble-label">Bulanan</div>
      </a>
      @endcan

      @can('manage_prayers')
      <a href="{{ route('prayers.index') }}" class="menu-bubble-item">
        <div class="menu-bubble-icon ic-dark"><i class="bi bi-clock-history"></i></div>
        <div class="menu-bubble-label">Jadwal</div>
      </a>
      @endcan

    @can('manage_prayers')
    <a href="{{ route('activities.index') }}" class="menu-bubble-item">
      <div class="menu-bubble-icon ic-info"><i class="bi bi-calendar-check"></i></div>
      <div class="menu-bubble-label">Kegiatan</div>
    </a>
    @endcan

    @can('view_reports')
    <a href="{{ route('activities.recap') }}" class="menu-bubble-item">
      <div class="menu-bubble-icon ic-primary"><i class="bi bi-clipboard-check"></i></div>
      <div class="menu-bubble-label">Rekap Kegiatan</div>
    </a>
    @endcan
      @can('manage_users')
      <a href="{{ route('users.index') }}" class="menu-bubble-item">
        <div class="menu-bubble-icon ic-danger"><i class="bi bi-person-gear"></i></div>
        <div class="menu-bubble-label">Users</div>
      </a>
      @endcan

      {{-- Profil (opsional, belum ada route khusus) --}}
      @auth
      <a href="{{ route('profile.show') }}" class="menu-bubble-item">
        <div class="menu-bubble-icon ic-primary"><i class="bi bi-person-circle"></i></div>
        <div class="menu-bubble-label">Profil</div>
      </a>
      @endauth

      {{-- Logout / Login --}}
      @auth
      <form method="POST" action="{{ route('logout') }}" class="m-0">
        @csrf
        <button type="submit" class="menu-bubble-item w-100 text-start border-0 bg-transparent">
          <div class="menu-bubble-icon ic-danger"><i class="bi bi-box-arrow-right"></i></div>
          <div class="menu-bubble-label">Logout</div>
        </button>
      </form>
      @else
      <a href="{{ route('login') }}" class="menu-bubble-item">
        <div class="menu-bubble-icon ic-primary"><i class="bi bi-box-arrow-in-right"></i></div>
        <div class="menu-bubble-label">Login</div>
      </a>
      @endauth

    </div>
  </div>
</div>

{{-- Banner sholat aktif --}}
@if($activePrayer)
  <div class="alert alert-success py-2 d-flex justify-content-between align-items-center">
    <div class="small">
      <span class="fw-semibold">Sholat aktif:</span>
      <span class="fw-semibold">{{ $activePrayer->name }}</span>
      <span class="text-muted">({{ $activePrayer->start_time }}–{{ $activePrayer->end_time }})</span>
      <span class="text-muted">• telat: {{ $activePrayer->late_minutes }} menit</span>
    </div>
    <span class="badge bg-success">LIVE</span>
  </div>
@else
  <div class="alert alert-warning py-2">
    <div class="small fw-semibold">Tidak ada sholat aktif saat ini.</div>
  </div>
@endif
@php
  // Total hari ini dari $items (sudah ada di dashboard kamu)
  $totalHadir = collect($items)->sum('hadir');
  $totalTelat = collect($items)->sum('telat');
  $totalBelum = collect($items)->sum('belum');

  $labelsSholat = collect($items)->map(fn($it) => $it['prayer']->name)->values();
  $dataHadirPerSholat = collect($items)->map(fn($it) => (int) $it['hadir'])->values();
  $dataTelatPerSholat = collect($items)->map(fn($it) => (int) $it['telat'])->values();
@endphp

<div class="row g-2 mb-3">
  {{-- Ringkasan angka --}}
  <div class="col-12 col-lg-4">
    <div class="card p-3">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="fw-semibold">Statistik Hari Ini</div>
          <div class="text-muted small">{{ $today }}</div>
        </div>
        <span class="badge bg-success-subtle text-success">LIVE</span>
      </div>

      <div class="row g-2 mt-2">
        <div class="col-4">
          <div class="small text-muted">Hadir</div>
          <div class="fw-bold fs-5 text-success">{{ $totalHadir }}</div>
        </div>
        <div class="col-4">
          <div class="small text-muted">Telat</div>
          <div class="fw-bold fs-5 text-warning">{{ $totalTelat }}</div>
        </div>
        <div class="col-4">
          <div class="small text-muted">Belum</div>
          <div class="fw-bold fs-5 text-danger">{{ $totalBelum }}</div>
        </div>
      </div>

      <div class="mt-3">
        <div class="small text-muted mb-2">Komposisi</div>
        <div style="height:220px;">
          <canvas id="chartDonut"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- Bar chart: Hadir per sholat --}}
  <div class="col-12 col-lg-8">
    <div class="card p-3">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="fw-semibold">Hadir per Sholat</div>
          <div class="text-muted small">Hari ini (total santri aktif: {{ $totalStudents }})</div>
        </div>
      </div>

      <div class="mt-2" style="height:320px;">
        <canvas id="chartBar"></canvas>
      </div>

      <div class="small text-muted mt-2">
        Tips: bar “Telat” bisa kamu pakai juga kalau mau lihat kedisiplinan.
      </div>
    </div>
  </div>
</div>

<script>
  // Data dari PHP -> JS
  const donutData = {
    hadir: @json((int) $totalHadir),
    telat: @json((int) $totalTelat),
    belum: @json((int) $totalBelum),
  };

  const labelsSholat = @json($labelsSholat);
  const hadirPerSholat = @json($dataHadirPerSholat);
  const telatPerSholat = @json($dataTelatPerSholat);

  // Doughnut Chart
  const ctxDonut = document.getElementById('chartDonut');
  new Chart(ctxDonut, {
    type: 'doughnut',
    data: {
      labels: ['Hadir', 'Telat', 'Belum'],
      datasets: [{
        data: [donutData.hadir, donutData.telat, donutData.belum],
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '68%',
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });

  // Bar Chart
  const ctxBar = document.getElementById('chartBar');
  new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: labelsSholat,
      datasets: [
        { label: 'Hadir', data: hadirPerSholat, borderWidth: 0 },
        { label: 'Telat', data: telatPerSholat, borderWidth: 0 },
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 } }
      },
      plugins: {
        legend: { position: 'bottom' },
        tooltip: { enabled: true }
      }
    }
  });
</script>

{{-- Jadwal sholat --}}
<div class="card mb-3">
  <div class="card-header bg-white py-2">
    <span class="fw-semibold small">Jadwal Sholat</span>
    <span class="text-muted small">• hari ini</span>
  </div>

  <div class="table-responsive">
    <table class="table table-sm align-middle mb-0 small">
      <thead class="table-light">
        <tr>
          <th>Sholat</th>
          <th style="width:150px;">Jam</th>
          <th style="width:120px;">Telat</th>
          <th style="width:90px;">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $it)
          @php
            $p = $it['prayer'];
            $st = $it['status'];
          @endphp
          <tr>
            <td class="fw-semibold">{{ $p->name }}</td>
            <td class="text-muted">{{ $p->start_time }} – {{ $p->end_time }}</td>
            <td class="text-muted">{{ $p->late_minutes }} menit</td>
            <td>
              @if($st === 'live')
                <span class="badge bg-success-subtle text-success">LIVE</span>
              @elseif($st === 'soon')
                <span class="badge bg-secondary-subtle text-secondary">Soon</span>
              @else
                <span class="badge bg-dark-subtle text-dark">Closed</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="card-footer py-2 small text-muted">
    Total santri aktif: <span class="fw-semibold">{{ $totalStudents }}</span>
  </div>
</div>

{{-- Ringkasan per sholat --}}
<div class="row g-2">
  @foreach($items as $it)
    @php
      $p = $it['prayer'];
      $st = $it['status'];
    @endphp

    <div class="col-12 col-md-6 col-lg-4">
      <div class="card p-2">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="fw-semibold small mb-0">{{ $p->name }}</div>
            <div class="text-muted" style="font-size:12px;">
              {{ $p->start_time }}–{{ $p->end_time }}
            </div>
          </div>

          <div class="text-end">
            @if($st === 'live')
              <span class="badge bg-success">LIVE</span>
            @elseif($st === 'soon')
              <span class="badge bg-secondary">Soon</span>
            @else
              <span class="badge bg-dark">Closed</span>
            @endif
          </div>
        </div>

        <div class="row g-2 mt-2 small">
          <div class="col-4">
            <div class="text-muted">Hadir</div>
            <div class="fw-semibold text-success">{{ $it['hadir'] }}</div>
          </div>
          <div class="col-4">
            <div class="text-muted">Telat</div>
            <div class="fw-semibold text-warning">{{ $it['telat'] }}</div>
          </div>
          <div class="col-4">
            <div class="text-muted">Belum</div>
            <div class="fw-semibold text-danger">{{ $it['belum'] }}</div>
          </div>
        </div>

        <div class="mt-2">
          <div class="d-flex justify-content-between small text-muted">
            <span>Progress</span>
            <span class="fw-semibold">{{ $it['progress'] }}%</span>
          </div>
          <div class="progress" style="height: 6px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $it['progress'] }}%"></div>
          </div>
        </div>

        <div class="d-flex gap-2 mt-2">
          <a class="btn btn-outline-primary btn-sm w-100"
             href="{{ route('rekap.index', ['date'=>$today, 'prayer_id'=>$p->id]) }}">
            Rekap
          </a>
        </div>
      </div>
    </div>
  @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

@endsection
