@extends('layouts.app')
@section('title','Edit User')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
  <div>
    <h5 class="fw-semibold mb-0">Edit User</h5>
    <div class="text-muted small">{{ $user->name }} • {{ $user->email }}</div>
  </div>
  <a href="{{ route('users.index') }}" class="btn btn-light btn-sm">Kembali</a>
</div>

@if ($errors->any())
  <div class="alert alert-danger py-2 small">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="card p-3">
  <form method="POST" action="{{ route('users.update', $user) }} " enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-2">
      <div class="col-12 col-md-6">
        <label class="form-label small mb-1">Nama</label>
        <input name="name" class="form-control form-control-sm"
               value="{{ old('name', $user->name) }}" required>
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label small mb-1">Email</label>
        <input name="email" type="email" class="form-control form-control-sm"
               value="{{ old('email', $user->email) }}" required>
      </div>

        <div class="col-12 col-md-6">
        <label class="form-label small mb-1">No HP (opsional)</label>
        <input name="phone" class="form-control form-control-sm" value="{{ old('phone') }}" placeholder="08xxxx">
        </div>

        <div class="col-12">
        <div class="form-check mt-1">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
            <label class="form-check-label small" for="is_active">Akun Aktif</label>
        </div>
        </div>

        <div class="col-12">
        <label class="form-label small mb-1">Catatan (opsional)</label>
        <textarea name="notes" rows="2" class="form-control form-control-sm"
                    placeholder="Keterangan user...">{{ old('notes') }}</textarea>
        </div>

      <div class="col-12 col-md-6">
        <label class="form-label small mb-1">Role</label>
        <select name="role" class="form-select form-select-sm" required>
          @foreach($roles as $r)
            <option value="{{ $r }}" @selected(old('role', $currentRole)===$r)>{{ $r }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label small mb-1">Reset Password (opsional)</label>
        <input name="password" type="password" class="form-control form-control-sm"
               placeholder="Kosongkan jika tidak diubah">
      </div>
      <div class="col-12 col-md-6">
        <label class="form-label small mb-1">Foto Saat Ini</label><br>
        <img src="{{ $user->avatarUrl() }}"
            class="rounded"
            style="width:80px;height:80px;object-fit:cover;">
        </div>

      <div class="col-12 col-md-6">
        <label class="form-label small mb-1">Foto</label>
        <input type="file" name="avatar" class="form-control form-control-sm" accept="image/*">
        </div>

      <div class="col-12 d-flex gap-2 mt-2">
        <button class="btn btn-primary btn-sm">Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">Batal</a>
      </div>

      @if(auth()->id() === $user->id)
        <div class="col-12">
          <div class="text-muted" style="font-size:12px;">
            Catatan: kamu sedang mengedit akun sendiri. Hapus akun sendiri tidak diperbolehkan.
          </div>
        </div>
      @endif
    </div>
  </form>
</div>
@endsection
