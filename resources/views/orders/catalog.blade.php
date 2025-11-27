@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0 fw-bold">Katalog Produk</h3>
  <div class="d-flex align-items-center gap-2">
  <form method="GET" class="d-none d-md-flex" action="{{ url()->current() }}">
      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" name="q" class="form-control" placeholder="Cari nama, SKU, atau deskripsi..." value="{{ $q ?? request('q') }}" />
        @if(!empty($q))
          <a href="{{ url()->current() }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
        @endif
        <button class="btn btn-primary">Cari</button>
      </div>
    </form>
    @if(auth()->check() && in_array(auth()->user()->role, ['admin','cashier']))
      <a href="{{ route('products.create') }}" class="btn btn-outline-secondary"><i class="bi bi-plus-circle me-2"></i>Tambah Produk</a>
    @endif
    <a href="{{ route('cart.view') }}" class="btn btn-outline-secondary"><i class="bi bi-cart3 me-2"></i>Lihat Keranjang</a>
  </div>
  
</div>
<!-- Mobile search (visible on small screens) -->
<div class="mb-3 d-flex d-md-none">
  <form method="GET" class="w-100" action="{{ url()->current() }}">
    <div class="input-group">
      <span class="input-group-text"><i class="bi bi-search"></i></span>
      <input type="text" name="q" class="form-control" placeholder="Cari nama, SKU, atau deskripsi..." value="{{ $q ?? request('q') }}" />
      @if(!empty($q))
        <a href="{{ url()->current() }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
      @endif
      <button class="btn btn-primary">Cari</button>
    </div>
  </form>
  </div>

@if(!empty($q))
  <div class="alert alert-light mb-3" style="border:1px dashed var(--e-border);">
    Menampilkan hasil untuk: <span class="fw-semibold">"{{ $q }}"</span>
  </div>
@endif
<div class="row row-cols-2 row-cols-md-4 g-3">
  @forelse($products as $p)
  <div class="col reveal">
    <div class="card product-card h-100">
      @php
        $imgUrl = $p->image_path ? route('media.show', ['path' => $p->image_path]) : 'https://via.placeholder.com/300x200?text=No+Image';
      @endphp
      <img src="{{ $imgUrl }}" class="card-img-top" alt="{{ $p->name }}">
      <div class="card-body d-flex flex-column">
        <h6 class="card-title fw-semibold">{{ $p->name }}</h6>
        <div class="mb-2 d-flex align-items-center justify-content-between">
          <div>
            <span class="price">Rp {{ number_format($p->final_price,0,',','.') }}</span>
            <small class="text-muted">@if($p->discount_type!='none')<del>Rp {{ number_format($p->price,0,',','.') }}</del>@endif</small>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#productDetail-{{ $p->id }}" title="Detail Produk">
            <i class="bi bi-info-circle"></i>
          </button>
        </div>
        <form method="POST" action="{{ route('cart.add', $p) }}" class="mt-auto">@csrf
          <div class="input-group">
            <input type="number" name="qty" class="form-control" min="1" value="1" style="max-width: 90px;">
            <button class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Tambah</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Product Detail Modal -->
    <div class="modal fade" id="productDetail-{{ $p->id }}" tabindex="-1" aria-labelledby="productDetailLabel-{{ $p->id }}" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bold" id="productDetailLabel-{{ $p->id }}">{{ $p->name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="d-flex align-items-start gap-3">
              <img src="{{ $imgUrl }}" alt="{{ $p->name }}" style="width: 96px; height: 96px; object-fit: cover; border-radius: 12px; background:#f8f9fa;">
              <div>
                <div class="mb-1"><span class="text-muted">SKU:</span> <span class="fw-semibold">{{ $p->sku ?? '-' }}</span></div>
                <div class="mb-1"><span class="text-muted">Harga:</span> <span class="fw-semibold">Rp {{ number_format($p->final_price,0,',','.') }}</span></div>
                @if($p->discount_type!='none')
                <div class="small text-muted">Harga normal: Rp {{ number_format($p->price,0,',','.') }}</div>
                @endif
              </div>
            </div>
            <hr/>
            <div>
              <div class="fw-semibold mb-1">Deskripsi</div>
              <div class="text-muted" style="white-space: pre-line;">{{ $p->description ?: 'Tidak ada deskripsi.' }}</div>
            </div>
          </div>
          <div class="modal-footer">
            <form method="POST" action="{{ route('cart.add', $p) }}" class="ms-auto">@csrf
              <div class="input-group">
                <input type="number" name="qty" class="form-control" min="1" value="1" style="max-width: 90px;">
                <button class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Tambah ke Keranjang</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @empty
  <div class="col-12">
    <div class="card">
      <div class="card-body text-center py-5">
        <i class="bi bi-search" style="font-size: 3rem; opacity: 0.3;"></i>
        <div class="mt-2">Tidak ada produk yang cocok.</div>
      </div>
    </div>
  </div>
  @endforelse
</div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection
