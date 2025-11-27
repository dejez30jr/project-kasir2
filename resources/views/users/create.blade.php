@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0 fw-bold">Tambah Pengguna</h3>
  <a href="{{ route('users.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('users.store') }}" class="row g-3">@csrf
      <div class="col-md-6">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Telepon</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Peran</label>
        <select name="role" class="form-select" required>
          @foreach($roles as $val => $label)
            <option value="{{ $val }}" @selected(old('role')===$val)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required minlength="6">
      </div>
      <div class="col-md-6">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" required minlength="6">
      </div>
      <div class="col-12 d-flex justify-content-end">
        <button class="btn btn-primary px-4"><i class="bi bi-check2-circle me-2"></i>Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
