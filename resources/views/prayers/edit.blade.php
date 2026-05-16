@extends('layouts.app')
@section('title','Edit Jadwal Sholat')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
  <div>
    <h5 class="fw-semibold mb-0">Edit Jadwal</h5>
    <div class="text-muted small">{{ $prayer->name }}</div>
  </div>
  <a href="{{ route('prayers.index') }}" class="btn btn-light btn-sm">Kembali</a>
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
  <form method="POST" action="{{ route('prayers.update', $prayer) }}">
    @csrf
    @method('PUT')

    <div class="row g-2">
      <div class="col-6 col-md-4">
        <label class="form-label small mb-1">Jam Mulai (Buka Scan)</label>
        <input type="time" name="start_time"
               class="form-control form-control-sm"
               value="{{ old('start_time', substr($prayer->start_time,0,5)) }}">
      </div>

      <div class="col-6 col-md-4">
        <label class="form-label small mb-1">Jam Selesai (Tutup Scan)</label>
        <input type="time" name="end_time"
               class="form-control form-control-sm"
               value="{{ old('end_time', substr($prayer->end_time,0,5)) }}">
      </div>

      <div class="col-6 col-md-4">
        <label class="form-label small mb-1">Toleransi Telat (menit)</label>
        <input type="number" name="late_minutes"
               class="form-control form-control-sm"
               min="0" max="180"
               value="{{ old('late_minutes', $prayer->late_minutes) }}">
      </div>

      <div class="col-12">
        <div class="form-check mt-2">
          <input class="form-check-input" type="checkbox" name="is_active" value="1"
                 id="is_active" @checked(old('is_active', $prayer->is_active))>
          <label class="form-check-label small" for="is_active">
            Aktifkan sholat ini (muncul di jadwal & perhitungan)
          </label>
        </div>
      </div>

      <div class="col-12 d-flex gap-2 mt-2">
        <button class="btn btn-primary btn-sm">Simpan</button>
        <a href="{{ route('prayers.index') }}" class="btn btn-outline-secondary btn-sm">Batal</a>
      </div>

      <div class="col-12">
        <div class="text-muted" style="font-size:12px;">
          Catatan: Pastikan jam mulai & selesai sesuai waktu setempat. Scan hanya bisa saat sholat aktif.
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
