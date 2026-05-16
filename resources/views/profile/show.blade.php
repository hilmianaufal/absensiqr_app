@extends('layouts.app')
@section('title','Profil Saya')

@section('content')
<div class="container px-2" style="max-width:460px;">

  {{-- Header Profil --}}
  <div class="card mb-3">
    <div class="card-body text-center">
      <img src="{{ $user->avatarUrl() }}"
           class="rounded-circle mb-2"
           style="width:90px;height:90px;object-fit:cover;">

      <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
      <div class="text-muted small">{{ $user->email }}</div>

      <div class="mt-2">
        @foreach($user->roles as $r)
          <span class="badge bg-success-subtle text-success">
            {{ ucfirst($r->name) }}
          </span>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Detail Data --}}
  <div class="card mb-3">
    <div class="card-header bg-white fw-semibold small">
      Informasi Akun
    </div>
    <div class="card-body small">
      <div class="row mb-2">
        <div class="col-5 text-muted">Nama</div>
        <div class="col-7 fw-semibold">{{ $user->name }}</div>
      </div>

      <div class="row mb-2">
        <div class="col-5 text-muted">Email</div>
        <div class="col-7">{{ $user->email }}</div>
      </div>

      <div class="row mb-2">
        <div class="col-5 text-muted">No. HP</div>
        <div class="col-7">{{ $user->phone ?? '-' }}</div>
      </div>

      <div class="row mb-2">
        <div class="col-5 text-muted">Status</div>
        <div class="col-7">
          @if($user->is_active)
            <span class="badge bg-success-subtle text-success">Aktif</span>
          @else
            <span class="badge bg-danger-subtle text-danger">Nonaktif</span>
          @endif
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-5 text-muted">Login Terakhir</div>
        <div class="col-7">
          {{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : '-' }}
        </div>
      </div>

      <div class="row">
        <div class="col-5 text-muted">Catatan</div>
        <div class="col-7">{{ $user->notes ?? '-' }}</div>
      </div>
    </div>
  </div>

  {{-- Aksi --}}
  <div class="d-grid gap-2">
    <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary btn-sm">
      Edit Profil
    </a>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="btn btn-outline-danger btn-sm w-100">
        Logout
      </button>
    </form>
  </div>

</div>
@endsection
