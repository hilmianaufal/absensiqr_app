@extends('layouts.app')
@section('title','Tambah Santri')

@section('content')
<h4 class="fw-bold mb-3">Tambah Santri</h4>
<div class="card p-3">
  <form method="POST" action="{{ route('students.store') }}">
    @include('students._form', ['student' => null])
  </form>
</div>
@endsection
