@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card fade-in modern" style="overflow: hidden;">
      <div class="card-body p-4">
        <div class="text-center mb-4">
          <div style="width: 72px; height: 72px; background: var(--primary-gradient); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-box-arrow-in-right text-white" style="font-size: 2rem;"></i>
          </div>
          <h3 class="fw-bold mb-1">Selamat Datang</h3>
          <p class="text-muted">Silakan login untuk melanjutkan</p>
        </div>
        <form method="POST" action="{{ route('login.post') }}">@csrf
          <div class="mb-3">
            <label class="form-label fw-semibold"><i class="bi bi-envelope me-2"></i>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="nama@email.com" required>
          </div>
          <div class="mb-4">
            <label class="form-label fw-semibold"><i class="bi bi-lock me-2"></i>Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
          </div>
          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Ingat saya</label>
          </div>
          <button class="btn btn-primary w-100 py-2 mb-3">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
          </button>
          <div class="text-center">
            <p class="text-muted mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Daftar sekarang</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
