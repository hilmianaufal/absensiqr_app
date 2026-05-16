@extends('layouts.app')
@section('title','Data Santri')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
  <div>
    <h4 class="fw-bold mb-0">Data Santri</h4>
    <div class="text-muted small">Kelola data santri dan QR token</div>
  </div>
  <a href="{{ route('students.create') }}" class="btn btn-success">+ Tambah Santri</a>
</div>

<form class="card p-3 mb-3" method="GET" action="{{ route('students.index') }}">
  <div class="row g-2">
    <div class="col-12 col-md-4">
      <input name="q" value="{{ $q }}" class="form-control" placeholder="Cari NIS / Nama...">
    </div>

    <div class="col-6 col-md-3">
      <select name="kelas" class="form-select">
        <option value="">Semua Kelas</option>
        @foreach($kelasList as $k)
          <option value="{{ $k }}" @selected($kelas===$k)>{{ $k }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-6 col-md-3">
      <select name="kamar" class="form-select">
        <option value="">Semua Kamar</option>
        @foreach($kamarList as $km)
          <option value="{{ $km }}" @selected($kamar===$km)>{{ $km }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-12 col-md-2 d-grid">
      <button class="btn btn-primary">Filter</button>
    </div>
  </div>

  {{-- tombol reset filter (opsional) --}}
  <div class="mt-2 d-flex justify-content-end">
    <a href="{{ route('students.index') }}" class="btn btn-link btn-sm text-decoration-none">Reset</a>
  </div>
</form>

<div class="card">
  <div class="table-responsive">
    {{-- table-sm + small biar padat --}}
    <table class="table table-hover align-middle mb-0 table-sm small">
      <thead class="table-light">
        <tr>
          <th style="width:110px;">NIS</th>
          <th>Nama</th>

          {{-- disembunyikan di layar kecil --}}
          <th class="d-none d-md-table-cell" style="width:90px;">Kelas</th>
          <th class="d-none d-md-table-cell" style="width:110px;">Kamar</th>

          <th style="width:90px;">Status</th>
          <th class="text-center" style="width:140px;">Aksi</th>
        </tr>
      </thead>

      <tbody>
        @forelse($students as $s)
          <tr>
            <td class="fw-semibold">{{ $s->nis }}</td>

            {{-- Nama + info kecil di mobile (kelas/kamar dipindah ke sini) --}}
            <td>
              <div class="fw-semibold">{{ $s->name }}</div>
              <div class="text-muted d-md-none" style="font-size: 12px;">
                {{ $s->kelas ?? '-' }} • {{ $s->kamar ?? '-' }}
              </div>
            </td>

            <td class="d-none d-md-table-cell">{{ $s->kelas ?? '-' }}</td>
            <td class="d-none d-md-table-cell">{{ $s->kamar ?? '-' }}</td>

            <td>
              @if($s->is_active)
                <span class="badge bg-success-subtle text-success">Aktif</span>
              @else
                <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
              @endif
            </td>

            {{-- Aksi jadi ikon, lebih hemat lebar --}}
            <td class="text-center">
              <div class="btn-group btn-group-sm" role="group" aria-label="Aksi">
                <a class="btn btn-outline-primary"
                   href="{{ route('students.show',$s) }}"
                   title="Detail">👁</a>

                <a class="btn btn-outline-secondary"
                   href="{{ route('students.edit',$s) }}"
                   title="Edit">✏️</a>

                <form method="POST" action="{{ route('students.destroy',$s) }}"
                      onsubmit="return confirm('Hapus santri ini?')" class="d-inline">
                  @csrf @method('DELETE')
                  <button class="btn btn-outline-danger" title="Hapus">🗑</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center text-muted py-4">Belum ada data.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="card-footer">
    {{ $students->links() }}
  </div>
</div>
@endsection
