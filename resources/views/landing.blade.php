@extends('layouts.app')

@section('content')
<section class="py-5 py-md-6">
  <div class="container-xl">
    <div class="row align-items-center g-5">
      <div class="col-md-6">
        <h1 class="fw-extrabold mb-3" style="font-size: clamp(2rem, 4vw, 3rem); line-height: 1.1;">
          Sistem Kasir Modern untuk Toko Anda
        </h1>
        <p class="text-muted mb-4" style="font-size: 1.05rem;">
          Kelola produk, stok, transaksi, dan laporan dengan cepat dan elegan. Dukungan scan barcode, diskon, checkout, dan rekap otomatis.
        </p>
        <div class="d-flex flex-wrap gap-2 mb-4">
          <span class="badge bg-dark"><i class="bi bi-lightning-charge me-1"></i> Cepat</span>
          <span class="badge bg-success"><i class="bi bi-shield-check me-1"></i> Aman</span>
          <span class="badge bg-primary"><i class="bi bi-ui-checks-grid me-1"></i> Mudah Dipakai</span>
        </div>
        <div class="d-flex gap-3">
          <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
          </a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-lg" style="border-radius: 20px; overflow:hidden;">
          <div class="ratio ratio-16x9 bg-light">
            <img src="/assets/img/" alt="Ilustrasi sistem kasir POS" style="object-fit: contain;">
          </div>
        </div>
      </div>
    </div>

    <div id="fitur" class="row g-4 mt-5">
      <div class="col-md-4">
        <div class="card h-100 p-3">
          <div class="d-flex align-items-center gap-3">
            <div class="bg-light rounded-3 p-3"><i class="bi bi-upc-scan" style="font-size:1.5rem;"></i></div>
            <div>
              <div class="fw-bold">Scan Barcode & SKU</div>
              <div class="text-muted small">Tambah ke keranjang cukup scan saja.</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 p-3">
          <div class="d-flex align-items-center gap-3">
            <div class="bg-light rounded-3 p-3"><i class="bi bi-box-seam" style="font-size:1.5rem;"></i></div>
            <div>
              <div class="fw-bold">Manajemen Stok</div>
              <div class="text-muted small">Stok masuk, awal, dan penyesuaian otomatis.</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 p-3">
          <div class="d-flex align-items-center gap-3">
            <div class="bg-light rounded-3 p-3"><i class="bi bi-receipt" style="font-size:1.5rem;"></i></div>
            <div>
              <div class="fw-bold">Checkout & Struk</div>
              <div class="text-muted small">Metode bayar fleksibel, struk siap unduh.</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mt-5">
      <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div class="mb-3 mb-md-0">
          <div class="fw-bold">Siap mulai?</div>
          <div class="text-muted">Masuk sekarang untuk menggunakan sistem kasir.</div>
        </div>
        <a href="{{ route('login') }}" class="btn btn-success btn-lg px-4"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
      </div>
    </div>
  </div>
</section>
@endsection
