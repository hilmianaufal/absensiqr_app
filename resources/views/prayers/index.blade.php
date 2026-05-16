@extends('layouts.app')
@section('title','Jadwal Sholat')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
  <div>
    <h5 class="fw-semibold mb-0">Jadwal Sholat</h5>
    <div class="text-muted small">Atur jam buka/tutup scan dan toleransi telat</div>
  </div>
  <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">Dashboard</a>
</div>

@if(session('success'))
  <div class="alert alert-success py-2 small">{{ session('success') }}</div>
@endif

<div class="card">
  <div class="table-responsive">
    <table class="table table-sm align-middle mb-0 small">
      <thead class="table-light">
        <tr>
          <th>Sholat</th>
          <th style="width:170px;">Jam</th>
          <th style="width:140px;">Telat</th>
          <th style="width:90px;">Aktif</th>
          <th class="text-end" style="width:90px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($prayers as $p)
          <tr>
            <td class="fw-semibold">{{ $p->name }}</td>
            <td class="text-muted">{{ $p->start_time }} – {{ $p->end_time }}</td>
            <td class="text-muted">{{ $p->late_minutes }} menit</td>
            <td>
              @if($p->is_active)
                <span class="badge bg-success-subtle text-success">Aktif</span>
              @else
                <span class="badge bg-secondary-subtle text-secondary">Off</span>
              @endif
            </td>
            <td class="text-end">
              <a href="{{ route('prayers.edit', $p) }}" class="btn btn-outline-primary btn-sm">Edit</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
