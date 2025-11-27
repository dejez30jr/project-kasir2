@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0 fw-bold">Edit Pengguna</h3>
  <a href="{{ route('users.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('users.update', $user) }}" class="row g-3">@csrf @method('PUT')
      <div class="col-md-6">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Telepon</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Peran</label>
        <select name="role" class="form-select" required>
          @foreach($roles as $val => $label)
            <option value="{{ $val }}" @selected(old('role', $user->role)===$val)>{{ $label }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-12">
        <div class="alert alert-light" style="border:1px dashed var(--e-border);">
          <div class="fw-semibold mb-2"><i class="bi bi-shield-lock me-2"></i>Ubah Password (Opsional)</div>
          <div class="row g-2">
            <div class="col-md-4">
              <label class="form-label">Password Baru</label>
              <input type="password" name="password" class="form-control" minlength="6">
            </div>
            <div class="col-md-4">
              <label class="form-label">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" class="form-control" minlength="6">
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 d-flex justify-content-end">
        <button class="btn btn-primary px-4"><i class="bi bi-save2 me-2"></i>Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection
