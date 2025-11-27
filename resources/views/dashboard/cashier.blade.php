@extends('layouts.app')

@section('content')
<div class="mb-4">
  <h2 class="fw-bold mb-1"><i class="bi bi-grid me-2"></i>Dashboard Kasir</h2>
  <p class="text-muted">Katalog Produk & Pesanan</p>
  </div>

<div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
  @foreach($products as $p)
  <div class="col">
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
        <h6 class="card-title fw-bold mb-2">{{ $p->name }}</h6>
        <div class="mb-3">
          <span class="fw-bold" style="font-size: 1.2rem; color: #11998e;">Rp {{ number_format($p->final_price,0,',','.') }}</span>
          @if($p->discount_type!='none')
            <small class="text-muted text-decoration-line-through ms-2">Rp {{ number_format($p->price,0,',','.') }}</small>
          @endif
        </div>
        <form method="POST" action="{{ route('cart.add', $p) }}" class="mt-auto">@csrf
          <div class="input-group">
            <input type="number" name="qty" class="form-control" min="1" value="1" style="max-width: 80px;">
            <button class="btn btn-primary flex-grow-1"><i class="bi bi-plus-circle me-1"></i>Tambah</button>
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
    <h5 class="card-title mb-4"><i class="bi bi-clock-history me-2"></i>Pesanan Pending / Belum Dibayar</h5>
    <div class="list-group list-group-flush">
      @forelse($pending as $o)
        <div class="list-group-item d-flex justify-content-between align-items-center" style="border-radius: 12px !important;">
          <div>
            <span class="fw-bold">#{{ $o->id }}</span>
            <span class="badge bg-info text-dark ms-2">{{ $o->order_type === 'pickup_later' ? 'Ambil Nanti' : 'Di Toko' }}</span>
            <span class="ms-2 text-muted">Rp {{ number_format($o->grand_total,0,',','.') }}</span>
          </div>
          <div class="d-flex gap-2">
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('orders.receipt', $o) }}" target="_blank">
              <i class="bi bi-receipt me-1"></i>Struk
            </a>
            <form method="POST" action="{{ route('orders.markPaid', $o) }}" class="d-flex align-items-center gap-2">@csrf
              <select name="payment_method" class="form-select form-select-sm" style="width:auto;">
                <option value="cash" {{ $o->payment_method==='cash'?'selected':'' }}>Cash</option>
                <option value="transfer" {{ $o->payment_method==='transfer'?'selected':'' }}>Transfer</option>
                <option value="qris" {{ $o->payment_method==='qris'?'selected':'' }}>QRIS</option>
              </select>
              <button class="btn btn-sm btn-success">
                <i class="bi bi-check-circle me-1"></i>Sudah Dibayar
              </button>
            </form>
          </div>
        </div>
      @empty
        <div class="text-center text-muted py-5">
          <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
          <p class="mt-2">Tidak ada pesanan pending</p>
        </div>
      @endforelse
    </div>
  </div>
</div>

@include('components.floating_cart')
@endsection
