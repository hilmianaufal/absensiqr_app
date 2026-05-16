@extends('layouts.app')
@section('title','Manajemen User')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
  <div>
    <h5 class="fw-semibold mb-0">Manajemen User</h5>
    <div class="text-muted small">Kelola akun & role</div>
  </div>
  <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">+ Tambah User</a>
</div>

@if(session('success'))
  <div class="alert alert-success py-2 small mb-2">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger py-2 small mb-2">{{ session('error') }}</div>
@endif

<form class="card p-3 mb-3" method="GET">
  <div class="row g-2 align-items-end">
    <div class="col-12 col-md-4">
      <label class="form-label small mb-1">Cari</label>
      <input name="q" value="{{ $q }}" class="form-control form-control-sm" placeholder="Nama / email / HP...">
    </div>

    <div class="col-6 col-md-3">
      <label class="form-label small mb-1">Role</label>
      <select name="role" class="form-select form-select-sm">
        <option value="">Semua</option>
        @foreach($roles as $r)
          <option value="{{ $r }}" @selected($role===$r)>{{ $r }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-6 col-md-3">
      <label class="form-label small mb-1">Status</label>
      <select name="status" class="form-select form-select-sm">
        <option value="">Semua</option>
        <option value="active" @selected($status==='active')>Aktif</option>
        <option value="inactive" @selected($status==='inactive')>Nonaktif</option>
      </select>
    </div>

    <div class="col-12 col-md-2 d-grid">
      <button class="btn btn-primary btn-sm">Filter</button>
    </div>
  </div>
</form>

<div class="card">
  <div class="table-responsive" style="-webkit-overflow-scrolling: touch;">
    <table class="table table-sm align-middle mb-0">
      <thead class="table-light small">
        <tr>
          <th style="width:54px;" class="text-center">Foto</th>
          <th>Nama</th>
          <th style="width:120px;">Role</th>
          <th style="width:90px;" class="text-end">Aksi</th>
        </tr>
      </thead>

      <tbody class="small">
        @forelse($users as $u)
          @php $roleName = $u->roles->pluck('name')->first(); @endphp
          <tr>
            <td class="text-center">
              <img
                src="{{ method_exists($u,'avatarUrl') ? $u->avatarUrl() : asset('images/avatar-default.png') }}"
                class="rounded-circle"
                style="width:36px;height:36px;object-fit:cover;"
                alt="avatar">
            </td>

            <td>
              <div class="fw-semibold" style="line-height:1.1;">{{ $u->name }}</div>
              <div class="text-muted" style="font-size:12px;">
                {{ $u->email }}
              </div>
            </td>

            <td>
              @if($roleName)
                <span class="badge bg-primary-subtle text-primary">{{ $roleName }}</span>
              @else
                <span class="badge bg-secondary-subtle text-secondary">-</span>
              @endif
            </td>

            <td class="text-end">
              <a href="{{ route('users.edit', $u) }}"
                 class="btn btn-outline-primary btn-sm px-2"
                 title="Edit">
                ✏️
              </a>

              <form class="d-inline" method="POST" action="{{ route('users.destroy', $u) }}"
                    onsubmit="return confirm('Hapus user ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger btn-sm px-2"
                        title="Hapus"
                        {{ auth()->id()===$u->id ? 'disabled' : '' }}>
                  🗑️
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center text-muted py-4">Belum ada user.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="card-footer py-2">
    {{ $users->links() }}
  </div>
</div>
@endsection
