@extends('layouts.app')
@section('title','Edit Kegiatan')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
  <div>
    <h5 class="fw-semibold mb-0">Edit Kegiatan</h5>
    <div class="text-muted small">{{ $activity->name }}</div>
  </div>
  <a href="{{ route('activities.index') }}" class="btn btn-light btn-sm">Kembali</a>
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
  <form method="POST" action="{{ route('activities.update', $activity) }}">
    @csrf
    @method('PUT')

    <div class="row g-2">
      <div class="col-12">
        <label class="form-label small mb-1">Nama Kegiatan</label>
        <input name="name" class="form-control form-control-sm"
               value="{{ old('name', $activity->name) }}" required>
      </div>

      <div class="col-12 col-md-4">
        <label class="form-label small mb-1">Tipe</label>
        <select name="type" id="type" class="form-select form-select-sm" required>
          <option value="routine" @selected(old('type', $activity->type) === 'routine')>Rutin</option>
          <option value="manual" @selected(old('type', $activity->type) === 'manual')>Manual / Event</option>
        </select>
      </div>

      <div class="col-12 col-md-8" id="daysBox">
        <label class="form-label small mb-1">Hari Rutin</label>
        @php
          $selectedDays = old('days', $activity->days ?? []);
          $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            0 => 'Ahad',
          ];
        @endphp

        <div class="d-flex flex-wrap gap-2">
          @foreach($days as $num => $label)
            <label class="form-check form-check-inline small">
              <input class="form-check-input" type="checkbox" name="days[]"
                     value="{{ $num }}" @checked(in_array($num, $selectedDays ?? []))>
              {{ $label }}
            </label>
          @endforeach
        </div>
      </div>

      <div class="col-12 col-md-4" id="eventDateBox">
        <label class="form-label small mb-1">Tanggal Event</label>
        <input type="date" name="event_date" class="form-control form-control-sm"
               value="{{ old('event_date', optional($activity->event_date)->format('Y-m-d')) }}">
      </div>

      <div class="col-6 col-md-4">
        <label class="form-label small mb-1">Jam Mulai</label>
        <input type="time" name="start_time" class="form-control form-control-sm"
               value="{{ old('start_time', substr($activity->start_time, 0, 5)) }}" required>
      </div>

      <div class="col-6 col-md-4">
        <label class="form-label small mb-1">Jam Selesai</label>
        <input type="time" name="end_time" class="form-control form-control-sm"
               value="{{ old('end_time', substr($activity->end_time, 0, 5)) }}" required>
      </div>

      <div class="col-6 col-md-4">
        <label class="form-label small mb-1">Toleransi Telat</label>
        <input type="number" name="late_minutes" class="form-control form-control-sm"
               min="0" max="180"
               value="{{ old('late_minutes', $activity->late_minutes) }}" required>
      </div>

      <div class="col-12">
        <div class="form-check mt-2">
          <input class="form-check-input" type="checkbox" name="is_active" value="1"
                 id="is_active" @checked(old('is_active', $activity->is_active))>
          <label class="form-check-label small" for="is_active">
            Aktifkan kegiatan ini
          </label>
        </div>
      </div>

      <div class="col-12 d-flex gap-2 mt-2">
        <button class="btn btn-primary btn-sm">Simpan</button>
        <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary btn-sm">Batal</a>
      </div>
    </div>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const type = document.getElementById('type');
  const daysBox = document.getElementById('daysBox');
  const eventDateBox = document.getElementById('eventDateBox');

  function toggleFields() {
    if (type.value === 'routine') {
      daysBox.classList.remove('d-none');
      eventDateBox.classList.add('d-none');
    } else {
      daysBox.classList.add('d-none');
      eventDateBox.classList.remove('d-none');
    }
  }

  type.addEventListener('change', toggleFields);
  toggleFields();
});
</script>
@endsection