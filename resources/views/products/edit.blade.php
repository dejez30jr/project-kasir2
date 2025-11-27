@extends('layouts.app')

@section('content')
<div class="card modern fade-in">
  <div class="card-body p-4">
    <h4 class="fw-bold mb-3"><i class="bi bi-pencil me-2"></i>Edit Produk</h4>
    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">@csrf @method('PUT')
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nama</label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">SKU</label>
      <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Harga Jual (Rp/pcs)</label>
      <input type="number" name="price" class="form-control" min="0" step="0.01" value="{{ old('price', $product->price) }}" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Jumlah pcs dalam satu pack</label>
      <input type="number" name="pack_size" class="form-control" min="1" value="{{ old('pack_size', $product->pack_size) }}" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Jenis Pack</label>
      <input type="text" name="pack_label" class="form-control" value="{{ old('pack_label', $product->pack_label) }}" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Diskon</label>
      <select name="discount_type" class="form-select">
        <option value="none" @selected($product->discount_type=='none')>Tidak ada</option>
        <option value="percent" @selected($product->discount_type=='percent')>Persen (%)</option>
        <option value="nominal" @selected($product->discount_type=='nominal')>Nominal (Rp)</option>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Nilai Diskon</label>
      <input type="number" name="discount_value" class="form-control" min="0" step="0.01" value="{{ old('discount_value', $product->discount_value) }}">
    </div>
    <div class="col-md-6">
      <label class="form-label">Gambar</label>
      <input type="file" name="image" class="form-control">
      @if($product->image_path)
        <img src="{{ route('media.show', ['path' => $product->image_path]) }}" class="mt-2" style="max-height:120px;">
      @endif
    </div>
    <div class="col-12">
      <label class="form-label">Deskripsi</label>
      <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-success px-4">Simpan</button>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
  </div>
    </form>
  </div>
</div>
@endsection
