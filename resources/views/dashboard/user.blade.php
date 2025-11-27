@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h2 class="fw-bold mb-1"><i class="bi bi-bag-heart me-2"></i>Katalog Produk</h2>
    <p class="text-muted mb-0">Pilih produk favorit Anda</p>
  </div>
  <a href="{{ route('cart.view') }}" class="btn btn-outline-secondary"><i class="bi bi-cart3 me-2"></i>Lihat Keranjang</a>
</div>

<div class="row row-cols-2 row-cols-md-4 g-3 mb-5">
  @foreach($products as $p)
  <div class="col reveal">
    <div class="card product-card h-100">
      <div style="position: relative; overflow: hidden; border-radius: 16px 16px 0 0;">
        <img src="{{ $p->image_path ? route('media.show', ['path' => $p->image_path]) : 'https://via.placeholder.com/300x200?text=No+Image' }}" class="card-img-top" alt="{{ $p->name }}">
        @if($p->discount_type!='none')
          <span class="badge bg-danger position-absolute top-0 end-0 m-2" style="font-size: 0.75rem; padding: 0.4rem 0.8rem;">
            <i class="bi bi-percent me-1"></i>DISKON
          </span>
        @endif
      </div>
      <div class="card-body d-flex flex-column">
        <h6 class="card-title fw-semibold mb-2">{{ $p->name }}</h6>
        <div class="mb-3">
          <span class="price">Rp {{ number_format($p->final_price,0,',','.') }}</span>
          @if($p->discount_type!='none')
            <small class="text-muted text-decoration-line-through ms-2">Rp {{ number_format($p->price,0,',','.') }}</small>
          @endif
        </div>
        <form method="POST" action="{{ route('cart.add', $p) }}" class="mt-auto">@csrf
          <div class="input-group">
            <input type="number" name="qty" class="form-control" min="1" value="1" style="max-width: 90px;">
            <button class="btn btn-primary flex-grow-1"><i class="bi bi-cart-plus me-1"></i>Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach
</div>
<div class="mb-4">{{ $products->links() }}</div>

<div class="card fade-in">
  <div class="card-body p-4">
    <h5 class="card-title mb-4"><i class="bi bi-clock-history me-2"></i>Riwayat Transaksi Terakhir</h5>
    <div class="list-group list-group-flush">
      @forelse($orders as $o)
        <div class="list-group-item d-flex justify-content-between align-items-center" style="border-radius: 12px !important;">
          <div>
            <span class="fw-bold">#{{ $o->id }}</span>
            <span class="badge bg-{{ $o->status==='paid'?'success':($o->status==='pending'?'warning':'secondary') }} ms-2 text-uppercase">{{ ucfirst($o->status) }}</span>
            <span class="ms-2 text-muted">Rp {{ number_format($o->grand_total,0,',','.') }}</span>
          </div>
          <a class="btn btn-sm btn-outline-secondary" href="{{ route('orders.receipt', $o) }}" target="_blank">
            <i class="bi bi-receipt me-1"></i>Lihat Struk
          </a>
        </div>
      @empty
        <div class="text-center text-muted py-5">
          <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
          <p class="mt-2">Belum ada transaksi</p>
        </div>
      @endforelse
    </div>
  </div>
</div>

@include('components.floating_cart')
@endsection
