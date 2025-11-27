@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="card fade-in modern">
      <div class="card-body p-4">
        <h4 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2"></i>Tambah Produk Baru</h4>
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">@csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-tag me-2"></i>Nama Produk</label>
              <input type="text" name="name" class="form-control" placeholder="Contoh: Air Mineral 600ml" required>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold"><i class="bi bi-upc me-2"></i>SKU</label>
              <input type="text" name="sku" class="form-control" placeholder="AM600" required>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold"><i class="bi bi-cash me-2"></i>Harga Jual (Rp/pcs)</label>
              <input type="number" name="price" class="form-control" min="0" step="0.01" placeholder="5000" required>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold"><i class="bi bi-currency-dollar me-2"></i>Harga Modal (Rp/pcs)</label>
              <input type="number" name="cost_price" class="form-control" min="0" step="0.01" placeholder="4000" required>
            </div>
            
            <div class="col-12"><hr></div>
            
            <div class="col-md-3">
              <label class="form-label fw-semibold"><i class="bi bi-boxes me-2"></i>Jumlah pcs dalam satu pack</label>
              <input type="number" name="pack_size" class="form-control" min="1" value="1" required>
              <small class="text-muted">Misal: 12</small>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Jenis Pack</label>
              <input type="text" name="pack_label" class="form-control" value="pcs" required>
              <small class="text-muted">Contoh: pcs/box/kardus</small>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold"><i class="bi bi-stack me-2"></i>Jumlah Pack Awal</label>
              <input type="number" name="initial_packs" class="form-control" min="0" value="0" placeholder="10">
              <small class="text-muted">Stok = pack × pcs/pack</small>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold"><i class="bi bi-123 me-2"></i>Tambah Pcs Awal</label>
              <input type="number" name="initial_pcs" class="form-control" min="0" value="0" placeholder="0">
              <small class="text-muted">Opsional — bisa isi salah satu atau keduanya</small>
            </div>
            
            <div class="col-12"><hr></div>
            
            <div class="col-md-3">
              <label class="form-label fw-semibold"><i class="bi bi-percent me-2"></i>Tipe Diskon</label>
              <select name="discount_type" class="form-select">
                <option value="none">Tidak ada</option>
                <option value="percent">Persen (%)</option>
                <option value="nominal">Nominal (Rp)</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Nilai Diskon</label>
              <input type="number" name="discount_value" class="form-control" min="0" step="0.01" value="0">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-image me-2"></i>Gambar Produk</label>
              <input type="file" name="image" class="form-control" accept="image/*">
              <small class="text-muted">Max 2MB, format: JPG, PNG</small>
            </div>
            
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-text-left me-2"></i>Deskripsi</label>
              <textarea name="description" class="form-control" rows="4" placeholder="Deskripsi produk (opsional)"></textarea>
            </div>
          </div>
          
          <div class="mt-4 d-flex gap-2">
            <button class="btn btn-success px-4">
              <i class="bi bi-check-circle me-2"></i>Simpan Produk
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
              <i class="bi bi-x-circle me-2"></i>Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
