@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card modern fade-in">
      <div class="card-body p-4">
        <h4 class="fw-bold mb-3"><i class="bi bi-box-arrow-in-down me-2"></i>Tambah Stok: {{ $product->name }} <span class="text-muted">({{ $product->sku }})</span></h4>
        @if(($product->cost_price ?? 0) <= 0)
          <div class="alert alert-warning">
            Produk ini belum memiliki harga modal. Tambahkan harga modal saat membuat produk baru. Stok masuk tidak bisa diproses sebelum harga modal tersedia.
          </div>
        @endif
        <div class="mb-3 text-muted">Stok saat ini: <span class="badge bg-secondary">{{ $product->stock }} {{ $product->pack_label }}</span> • Ukuran pack: {{ $product->pack_size }} {{ $product->pack_label }}/pack</div>
        <form method="POST" action="{{ route('products.stock.store', $product) }}">@csrf
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold"><i class="bi bi-boxes me-2"></i>Jumlah Pack</label>
              <input type="number" name="qty_packs" class="form-control" min="0" value="0">
              <small class="text-muted">Dikonversi ke pcs (pack × {{ $product->pack_size }})</small>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold"><i class="bi bi-stack me-2"></i>Tambah Pcs</label>
              <input type="number" name="qty_pcs" class="form-control" min="0" value="0">
              <small class="text-muted">Bisa isi salah satu atau keduanya</small>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold"><i class="bi bi-currency-dollar me-2"></i>Harga Modal (Rp/pcs)</label>
              <input type="text" class="form-control" value="Rp {{ number_format($product->cost_price ?? 0,0,',','.') }}" disabled>
              <small class="text-muted">Harga modal ditetapkan saat membuat produk.</small>
            </div>
          </div>
          <div class="mt-4 d-flex gap-2">
            <button class="btn btn-success px-4" @if(($product->cost_price ?? 0) <= 0) disabled @endif><i class="bi bi-check2-circle me-2"></i>Simpan</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4"><i class="bi bi-x-circle me-2"></i>Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
 </div>
@endsection
