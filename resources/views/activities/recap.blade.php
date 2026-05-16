@extends('layouts.app')
@section('title','Rekap Kegiatan')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
  <div>
    <h5 class="fw-semibold mb-0">Rekap Kegiatan</h5>
    <div class="text-muted small">Rekap absensi kegiatan keasramaan</div>
  </div>
  <a href="{{ route('activities.scan') }}" class="btn btn-success btn-sm">Scan Kegiatan</a>
</div>

<form class="card p-3 mb-3" method="GET">
  <div class="row g-2 align-items-end">
    <div class="col-6 col-md-4">
      <label class="form-label small mb-1">Tanggal</label>
      <input type="date" name="date" class="form-control form-control-sm" value="{{ $date }}">
    </div>

    <div class="col-6 col-md-5">
      <label class="form-label small mb-1">Kegiatan</label>
      <select name="activity_id" class="form-select form-select-sm">
        @foreach($activities as $a)
          <option value="{{ $a->id }}" @selected($selectedActivity && $selectedActivity->id === $a->id)>
            {{ $a->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-12 col-md-3 d-grid">
      <button class="btn btn-primary btn-sm">Terapkan</button>
    </div>
  </div>
</form>

<div class="row g-2 mb-3">
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Total Santri</div>
      <div class="fw-semibold">{{ $totalStudents }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Hadir</div>
      <div class="fw-semibold text-success">{{ $hadirCount }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Terlambat</div>
      <div class="fw-semibold text-warning">{{ $terlambatCount }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Belum</div>
      <div class="fw-semibold text-danger">{{ $belumCount }}</div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-12 col-lg-7">
    <div class="card">
      <div class="card-header bg-white py-2">
        <span class="fw-semibold small">Sudah Absen</span>
        @if($selectedActivity)
          <span class="text-muted small">• {{ $selectedActivity->name }} • {{ $date }}</span>
        @endif
      </div>

      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0 small">
          <thead class="table-light">
            <tr>
              <th>NIS</th>
              <th>Nama</th>
              <th>Status</th>
              <th class="text-end">Jam</th>
            </tr>
          </thead>
          <tbody>
            @forelse($attendances as $a)
              <tr>
                <td class="fw-semibold">{{ $a->student->nis }}</td>
                <td>
                  <div class="fw-semibold">{{ $a->student->name }}</div>
                  <div class="text-muted" style="font-size:12px;">
                    {{ $a->student->kelas ?? '-' }} • {{ $a->student->kamar ?? '-' }}
                  </div>
                </td>
                <td>
                  @if($a->status === 'hadir')
                    <span class="badge bg-success-subtle text-success">Hadir</span>
                  @else
                    <span class="badge bg-warning-subtle text-warning-emphasis">Telat</span>
                  @endif
                </td>
                <td class="text-end fw-semibold">
                  {{ optional($a->scanned_at)->format('H:i') }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center text-muted py-3">
                  Belum ada data absen.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-5">
    <div class="card">
      <div class="card-header bg-white py-2">
        <span class="fw-semibold small">Belum Absen</span>
      </div>

      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0 small">
          <thead class="table-light">
            <tr>
              <th>NIS</th>
              <th>Nama</th>
            </tr>
          </thead>
          <tbody>
            @forelse($absentStudents as $s)
              <tr>
                <td class="fw-semibold">{{ $s->nis }}</td>
                <td>
                  <div class="fw-semibold">{{ $s->name }}</div>
                  <div class="text-muted" style="font-size:12px;">
                    {{ $s->kelas ?? '-' }} • {{ $s->kamar ?? '-' }}
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="2" class="text-center text-muted py-3">
                  Tidak ada data belum absen.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection