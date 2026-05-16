@extends('layouts.app')
@section('title','Rekap Absensi')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div class="d-flex gap-2">
  <a href="{{ route('scan.index') }}" class="btn btn-success btn-sm">Scan QR</a>

  {{-- Export mengikuti query filter --}}
  <a class="btn btn-outline-success btn-sm"
     href="{{ route('rekap.export.excel', request()->query()) }}">
    Export Excel
  </a>

  <a class="btn btn-outline-danger btn-sm"
     href="{{ route('rekap.export.pdf', request()->query()) }}">
    Export PDF
  </a>

  <a class="btn btn-outline-warning btn-sm"
     href="{{ route('rekap.monthly', request()->query()) }}">
    Rekap Bulanan
  </a>

</div>
  <div>
    <h5 class="fw-semibold mb-0">Rekap Absensi</h5>
    <div class="text-muted small">Rekap per tanggal & sholat</div>
  </div>
  <a href="{{ route('scan.index') }}" class="btn btn-success btn-sm">Scan QR</a>
</div>

{{-- Filter --}}
<form class="card p-3 mb-3" method="GET">
  <div class="row g-2 align-items-end">
    <div class="col-6 col-md-3">
      <label class="form-label small mb-1">Tanggal</label>
      <input type="date" name="date" class="form-control form-control-sm" value="{{ $date }}">
    </div>

    <div class="col-6 col-md-3">
      <label class="form-label small mb-1">Sholat</label>
      <select name="prayer_id" class="form-select form-select-sm">
        @foreach($prayers as $p)
          <option value="{{ $p->id }}" @selected($selectedPrayer && $selectedPrayer->id === $p->id)>
            {{ $p->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-6 col-md-3">
      <label class="form-label small mb-1">Kelas</label>
      <select name="kelas" class="form-select form-select-sm">
        <option value="">Semua</option>
        @foreach($kelasList as $k)
          <option value="{{ $k }}" @selected($groupKelas===$k)>{{ $k }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-6 col-md-3">
      <label class="form-label small mb-1">Kamar</label>
      <select name="kamar" class="form-select form-select-sm">
        <option value="">Semua</option>
        @foreach($kamarList as $km)
          <option value="{{ $km }}" @selected($groupKamar===$km)>{{ $km }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-12 d-grid mt-2">
      <button class="btn btn-primary btn-sm">Terapkan</button>
    </div>
  </div>
</form>

{{-- Ringkasan --}}
<div class="row g-2 mb-3">
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Total Santri</div>
      <div class="fs-6 fw-semibold">{{ $totalStudents }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Hadir</div>
      <div class="fs-6 fw-semibold text-success">{{ $hadirCount }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Terlambat</div>
      <div class="fs-6 fw-semibold text-warning">{{ $terlambatCount }}</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card p-2">
      <div class="text-muted small">Belum Absen</div>
      <div class="fs-6 fw-semibold text-danger">{{ $belumCount }}</div>
    </div>
  </div>
</div>

<div class="row g-3">
  {{-- Sudah Absen --}}
  <div class="col-12 col-lg-7">
    <div class="card">
      <div class="card-header py-2 bg-white">
        <span class="fw-semibold small">
          Sudah Absen
          @if($selectedPrayer)
            • {{ $selectedPrayer->name }} • {{ $date }}
          @endif
        </span>
      </div>

      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0 small">
          <thead class="table-light">
            <tr>
              <th style="width:90px">NIS</th>
              <th>Nama</th>
              <th style="width:90px">Status</th>
              <th class="text-end" style="width:80px">Jam</th>
            </tr>
          </thead>
          <tbody>
            @forelse($attendances as $a)
              <tr>
                <td class="fw-semibold">{{ $a->student->nis }}</td>
                <td>
                  <div class="fw-semibold">{{ $a->student->name }}</div>
                  <div class="text-muted" style="font-size:12px">
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
                  {{ $a->scanned_at->format('H:i') }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center text-muted py-3">
                  Belum ada yang absen
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="card-footer py-2">
        {{ $attendances->links() }}
      </div>
    </div>
  </div>

  {{-- Belum Absen --}}
  <div class="col-12 col-lg-5">
    <div class="card">
      <div class="card-header py-2 bg-white">
        <span class="fw-semibold small">Belum Absen</span>
        <span class="text-muted small">• max 30</span>
      </div>

      <div class="list-group list-group-flush small">
        @forelse($absentStudents as $s)
          <div class="list-group-item py-2">
            <div class="fw-semibold">{{ $s->name }}</div>
            <div class="text-muted" style="font-size:12px">
              {{ $s->nis }} • {{ $s->kelas ?? '-' }} • {{ $s->kamar ?? '-' }}
            </div>
          </div>
        @empty
          <div class="list-group-item text-muted py-3">
            Semua sudah absen 🎉
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
