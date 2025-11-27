@extends('layouts.app')

@section('content')
<div class="d-print-none mb-4">
  <button class="btn btn-primary btn-lg" onclick="window.print()">
    <i class="bi bi-printer me-2"></i>Print Struk
  </button>
</div>

<div class="card fade-in" style="max-width: 800px; margin: 0 auto;">
  <div class="card-body p-5">
    <div class="text-center mb-4 pb-4 border-bottom">
  <h2 class="fw-bold mb-1" style="background: linear-gradient(90deg,#f4efe3,#d9caa0); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">
        <i class="bi bi-shop me-2"></i>Kasir geniois
      </h2>
      <p class="text-muted mb-0">Struk Pembelian</p>
    </div>
    
    <div class="row mb-4">
      <div class="col-6">
  <div class="mb-2"><strong>No. Invoice:</strong> <span class="badge bg-dark">#{{ $order->id }}</span></div>
        <div class="mb-2"><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}</div>
      </div>
      <div class="col-6 text-end">
        <div class="mb-2"><strong>Pelanggan:</strong> {{ $order->user->name }}</div>
        <div class="mb-2"><strong>Status:</strong> 
          <span class="badge bg-{{ $order->payment_status==='paid'?'success':'warning' }} text-uppercase">{{ $order->payment_status }}</span>
        </div>
        <div class="mb-2"><strong>Metode:</strong> <span class="text-capitalize">{{ $order->payment_method ?? '-' }}</span></div>
      </div>
    </div>
    
    <div class="table-responsive mb-4">
      <table class="table">
        <thead style="background: #f8f9fa;">
          <tr>
            <th>Produk</th>
            <th class="text-center">Qty</th>
            <th class="text-end">Harga</th>
            <th class="text-end">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($order->items as $it)
          <tr>
            <td class="fw-semibold">{{ $it->product->name }}</td>
            <td class="text-center">{{ $it->qty }}</td>
            <td class="text-end">Rp {{ number_format($it->unit_price,0,',','.') }}</td>
            <td class="text-end fw-bold">Rp {{ number_format($it->total,0,',','.') }}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot style="background: #f8f9fa;">
          <tr>
            <td colspan="3" class="text-end fw-semibold">Subtotal</td>
            <td class="text-end">Rp {{ number_format($order->subtotal,0,',','.') }}</td>
          </tr>
          <tr>
            <td colspan="3" class="text-end fw-semibold">Diskon</td>
            <td class="text-end text-danger">- Rp {{ number_format($order->discount_total,0,',','.') }}</td>
          </tr>
          <tr style="background: linear-gradient(135deg, rgba(0,0,0,.04), rgba(0,0,0,.06));">
            <td colspan="3" class="text-end fs-5 fw-bold">Grand Total</td>
            <td class="text-end fs-4 fw-bold" style="color: #0f766e;">Rp {{ number_format($order->grand_total,0,',','.') }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
    
    <div class="text-center pt-4 border-top">
      <p class="text-muted mb-1"><i class="bi bi-heart-fill text-danger"></i> Terima kasih atas pembelian Anda!</p>
      <p class="text-muted mb-0" style="font-size: 0.85rem;">Struk ini dicetak pada {{ now()->format('d M Y, H:i') }}</p>
    </div>
  </div>
</div>

<style>
@media print {
  body { background: white !important; }
  .navbar, .d-print-none { display: none !important; }
  .card { box-shadow: none !important; border: 1px solid #ddd !important; }
}
</style>
@endsection
