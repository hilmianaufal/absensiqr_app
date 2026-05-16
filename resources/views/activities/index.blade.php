@extends('layouts.app')
@section('title','Jadwal Kegiatan')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
  <div>
    <h5 class="fw-semibold mb-0">Jadwal Kegiatan</h5>
    <div class="text-muted small">Atur kegiatan rutin, absen dadakan, check in, dan check out</div>
  </div>
  <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">Dashboard</a>
</div>

@if(session('success'))
  <div class="alert alert-success py-2 small">{{ session('success') }}</div>
@endif

<div class="card">
  <div class="table-responsive">
    <a href="{{ route('activities.create') }}" class="btn btn-primary btn-sm">
      Tambah Kegiatan
    </a>
    <table class="table table-sm align-middle mb-0 small">
      <thead class="table-light">
        <tr>
          <th>Kegiatan</th>
          <th>Tipe</th>
          <th>Hari/Tanggal</th>
          <th>Jam</th>
          <th>Telat</th>
          <th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($activities as $a)
          <tr>
            <td class="fw-semibold">{{ $a->name }}</td>

            <td>
              @if($a->type === 'routine')
                <span class="badge bg-primary-subtle text-primary">Rutin</span>
              @else
                <span class="badge bg-warning-subtle text-warning-emphasis">Manual</span>
              @endif
            </td>

            <td class="text-muted">
              @if($a->type === 'routine')
                @php
                  $dayNames = [
                    0 => 'Ahad',
                    1 => 'Senin',
                    2 => 'Selasa',
                    3 => 'Rabu',
                    4 => 'Kamis',
                    5 => 'Jumat',
                    6 => 'Sabtu',
                  ];
                @endphp

                @foreach(($a->days ?? []) as $d)
                  <span class="badge bg-light text-dark border">{{ $dayNames[$d] ?? $d }}</span>
                @endforeach
              @else
                {{ $a->event_date ? $a->event_date->format('d M Y') : '-' }}
              @endif
            </td>

            <td class="text-muted">
              {{ substr($a->start_time, 0, 5) }} - {{ substr($a->end_time, 0, 5) }}
            </td>

            <td class="text-muted">{{ $a->late_minutes }} menit</td>

            <td>
              @if($a->is_active)
                <span class="badge bg-success-subtle text-success">Aktif</span>
              @else
                <span class="badge bg-secondary-subtle text-secondary">Off</span>
              @endif
            </td>

            <td class="text-end">
              <a href="{{ route('activities.edit', $a) }}" class="btn btn-outline-primary btn-sm">
                Edit
              </a>

              <form method="POST" action="{{ route('activities.destroy', $a) }}" class="d-inline"
                    onsubmit="return confirm('Hapus kegiatan ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger btn-sm">
                  Hapus
                </button>
              </form>
                </td>
            
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection