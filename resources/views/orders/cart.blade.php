@extends('layouts.app')

@section('content')
<div class="mb-4">
  <h2 class="fw-bold mb-1"><i class="bi bi-cart3 me-2"></i>Keranjang Belanja</h2>
  <p class="text-muted">Review pembelian Anda sebelum checkout</p>
</div>

{{-- Scan Bar (SKU/Barcode) --}}
<div class="alert alert-light d-flex align-items-center justify-content-between" style="border:1px dashed var(--e-border); border-radius: 14px;">
  <div class="d-flex align-items-center gap-2">
    <span class="badge bg-primary"><i class="bi bi-upc-scan me-1"></i> Mode Scan</span>
    <small class="text-muted">Arahkan kursor ke halaman ini dan scan barcode (scanner USB) — tekan Enter di akhir.</small>
  </div>
  <div class="text-end">
    <small class="text-muted">Fokus otomatis aktif</small>
  </div>
  <input id="scan-input" type="text" autocomplete="off" inputmode="none" style="position: absolute; opacity: 0; width: 1px; height: 1px; left: -9999px;" />
  <audio id="beep-ok" preload="auto">
    <source src="data:audio/wav;base64,UklGRiQAAABXQVZFZm10IBAAAAABAAEAESsAACJWAAACABYAAAABAAgAZGF0YQAAAAA=" type="audio/wav">
  </audio>
</div>

@if(empty($cart))
  <div class="card fade-in">
    <div class="card-body text-center py-5">
      <i class="bi bi-cart-x" style="font-size: 5rem; opacity: 0.2;"></i>
      <h5 class="mt-3 mb-2">Keranjang Kosong</h5>
      <p class="text-muted mb-4">Belum ada produk di keranjang Anda</p>
      <a href="{{ route('shop.catalog') }}" class="btn btn-primary">
        <i class="bi bi-bag me-2"></i>Mulai Belanja
      </a>
    </div>
  </div>
@else
  <div class="card fade-in mb-4">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover table-sm mb-0 align-middle">
          <thead>
            <tr>
              <th class="ps-4">Produk</th>
              <th class="text-center">Qty</th>
              <th class="text-center">Aksi</th>
              <th class="text-end">Harga Satuan</th>
              <th class="text-end pe-4">Total</th>
            </tr>
          </thead>
          <tbody>
            @php($grand=0)
            @foreach($products as $p)
              @php($qty = $cart[$p->id])
              @php($unit = $p->discount_type=='percent' ? $p->price*(1-$p->discount_value/100) : ($p->discount_type=='nominal'? max(0,$p->price-$p->discount_value) : $p->price))
              @php($total = $unit * $qty)
              @php($grand += $total)
              <tr>
                <td class="ps-4">
                  <div class="d-flex align-items-center">
                    <div class="me-3" style="width: 60px; height: 60px; background: #f8f9fa; border-radius: 12px; overflow: hidden;">
                      <img src="{{ $p->image_path ? route('media.show', ['path' => $p->image_path]) : 'https://via.placeholder.com/60' }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div>
                      <div class="fw-semibold">{{ $p->name }}</div>
                      @if($p->discount_type!='none')
                        <span class="badge bg-danger" style="font-size: 0.7rem;"><i class="bi bi-percent"></i> Diskon</span>
                      @endif
                    </div>
                  </div>
                </td>
                <td class="text-center align-middle">
                  <form method="POST" action="{{ route('cart.update', $p) }}" class="cart-update d-inline-flex align-items-center justify-content-center gap-2">@csrf
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-dec" title="Kurangi"><i class="bi bi-dash"></i></button>
                    <input type="number" name="qty" min="0" value="{{ $qty }}" class="form-control form-control-sm qty-input" style="width:80px">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-inc" title="Tambah"><i class="bi bi-plus"></i></button>
                  </form>
                </td>
                <td class="text-center align-middle">
                  <form method="POST" action="{{ route('cart.update', $p) }}" onsubmit="return confirm('Hapus item ini dari keranjang?')" class="d-inline">@csrf
                    <input type="hidden" name="qty" value="0">
                    <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash3"></i></button>
                  </form>
                </td>
                <td class="text-end align-middle fw-semibold">Rp {{ number_format($unit,0,',','.') }}</td>
                <td class="text-end pe-4 align-middle fw-bold" style="font-size: 1.05rem; color:#0f766e;">Rp {{ number_format($total,0,',','.') }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot style="background: linear-gradient(180deg, #f8f9fa 0%, white 100%);">
            <tr>
              <td colspan="3" class="text-end fs-5 fw-bold ps-4" style="padding: 1.5rem;">Grand Total</td>
              <td class="text-end pe-4 fs-4 fw-bold" style="padding: 1.5rem; color: #0f766e;">Rp {{ number_format($grand,0,',','.') }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  
  <div class="d-flex justify-content-between">
    <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Kosongkan seluruh keranjang?')">@csrf
      <button class="btn btn-outline-danger"><i class="bi bi-trash me-2"></i>Kosongkan Keranjang</button>
    </form>
    <a class="btn btn-success px-4 py-2" href="{{ route('checkout.form') }}"><i class="bi bi-credit-card me-2"></i>Lanjut ke Checkout</a>
  </div>
@endif
@endsection

@push('scripts')
<script>
  (function(){
    const tokenEl = document.querySelector('meta[name="csrf-token"]');
    const csrf = tokenEl ? tokenEl.getAttribute('content') : '';
    function submitForm(form){
      const fd = new FormData(form);
      fetch(form.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf },
        body: fd
      }).then(resp => {
        if (!resp.ok) throw new Error('Request failed');
        return resp.text();
      }).then(() => {
        location.reload();
      }).catch(() => {
        // fallback: normal submit
        form.submit();
      });
    }
    document.querySelectorAll('form.cart-update').forEach(form => {
      const input = form.querySelector('.qty-input');
      const inc = form.querySelector('.btn-inc');
      const dec = form.querySelector('.btn-dec');
      if (inc) inc.addEventListener('click', () => { input.stepUp(); submitForm(form); });
      if (dec) dec.addEventListener('click', () => { input.stepDown(); submitForm(form); });
      if (input) input.addEventListener('change', () => submitForm(form));
    });
  })();
</script>

<script>
  // Simple scan handler: captures fast-typed code ending with Enter from USB scanner
  (function(){
    const input = document.getElementById('scan-input');
    const ok = document.getElementById('beep-ok');
    const tokenEl = document.querySelector('meta[name="csrf-token"]');
    const csrf = tokenEl ? tokenEl.getAttribute('content') : '';

    function focusScan(){
      if (input) input.focus();
    }
    // Keep focus on hidden input
    document.addEventListener('click', focusScan);
    document.addEventListener('keydown', function(){
      // If user starts typing, ensure input focused to capture scanner stream
      if (document.activeElement !== input) focusScan();
    });
    window.addEventListener('load', focusScan);

    if (!input) return;
    input.addEventListener('keydown', function(e){
      if (e.key === 'Enter'){
        e.preventDefault();
        const code = input.value.trim();
        if (!code) return;
        // Submit via fetch to scan endpoint
        fetch("{{ route('cart.scan') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
          },
          body: JSON.stringify({ code })
        }).then(async (resp) => {
          const data = await resp.json().catch(()=>({}));
          if (!resp.ok || !data.ok){
            const msg = (data && data.message) ? data.message : 'Kode tidak dikenal';
            showScanToast(msg, 'danger');
            return;
          }
          if (ok && ok.play) { try { ok.currentTime = 0; ok.play(); } catch(_){} }
          showScanToast('Ditambahkan: ' + data.product.name + ' (SKU: ' + data.product.sku + ')', 'success');
          // Refresh numbers silently
          setTimeout(() => location.reload(), 300);
        }).catch(() => {
          showScanToast('Gagal kirim kode', 'danger');
        }).finally(() => {
          input.value = '';
          focusScan();
        });
      }
    });

    // Minimal toast
    function showScanToast(message, type){
      let toast = document.getElementById('scan-toast');
      if (!toast){
        toast = document.createElement('div');
        toast.id = 'scan-toast';
        toast.style.position = 'fixed';
        toast.style.right = '16px';
        toast.style.bottom = '16px';
        toast.style.zIndex = '1080';
        document.body.appendChild(toast);
      }
      const el = document.createElement('div');
      el.className = 'alert alert-' + (type || 'info') + ' shadow-sm mb-2';
      el.style.minWidth = '260px';
      el.innerHTML = '<i class="bi bi-upc-scan me-2"></i>' + message;
      toast.appendChild(el);
      setTimeout(() => { el.remove(); }, 2200);
    }
  })();
</script>
@endpush
