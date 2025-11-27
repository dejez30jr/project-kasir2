@php
  $cart = session('cart', []);
  $ids = array_keys($cart ?: [0]);
  $models = \App\Models\Product::whereIn('id', $ids)->get()->keyBy('id');
  $grand = 0;
@endphp

<div id="floatingCart" class="floating-cart shadow-lg">
  <div class="fc-header d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-cart3"></i>
      <strong>Keranjang</strong>
      <span class="badge bg-primary ms-1">{{ array_sum($cart) }}</span>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('cart.view') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye me-1"></i>Lihat</a>
      <a href="{{ route('checkout.form') }}" class="btn btn-sm btn-success"><i class="bi bi-bag-check me-1"></i>Checkout</a>
      <button id="fc-toggle" class="btn btn-sm btn-outline-primary" type="button" title="Minimize/Maximize">
        <i class="bi bi-chevron-down"></i>
      </button>
    </div>
  </div>
  <div class="fc-body">
    @if(empty($cart))
      <div class="text-center text-muted py-4">
        <i class="bi bi-cart-x" style="font-size:2rem;opacity:.4;"></i>
        <div class="mt-2">Keranjang kosong</div>
      </div>
    @else
      <div class="fc-items">
        @foreach($cart as $pid => $qty)
          @php($p = $models[$pid] ?? null)
          @continue(!$p)
          @php(
            $unit = $p->discount_type=='percent' ? $p->price*(1-$p->discount_value/100) : ($p->discount_type=='nominal'? max(0,$p->price-$p->discount_value) : $p->price)
          )
          @php($line = $unit * $qty)
          @php($grand += $line)
          <div class="fc-item d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
              <div class="thumb">
                <img src="{{ $p->image_path ? route('media.show', ['path' => $p->image_path]) : 'https://via.placeholder.com/40' }}" alt="{{ $p->name }}">
              </div>
              <div class="meta">
                <div class="name text-truncate" title="{{ $p->name }}">{{ $p->name }}</div>
                <div class="price small text-muted">Rp {{ number_format($unit,0,',','.') }}</div>
              </div>
            </div>
            <form method="POST" action="{{ route('cart.update', $p) }}" class="fc-update d-flex align-items-center gap-1">@csrf
              <button type="button" class="btn btn-sm btn-outline-secondary fc-dec"><i class="bi bi-dash"></i></button>
              <input type="number" name="qty" min="0" value="{{ $qty }}" class="form-control form-control-sm text-center fc-qty" style="width:64px">
              <button type="button" class="btn btn-sm btn-outline-secondary fc-inc"><i class="bi bi-plus"></i></button>
            </form>
            <div class="line-total fw-semibold">Rp {{ number_format($line,0,',','.') }}</div>
          </div>
        @endforeach
      </div>
      <div class="fc-summary d-flex align-items-center justify-content-between">
        <div class="text-muted">Grand Total</div>
        <div class="fw-bold">Rp {{ number_format($grand,0,',','.') }}</div>
      </div>
    @endif
  </div>
</div>

@push('scripts')
<script>
  (function(){
    const panel = document.getElementById('floatingCart');
    if (!panel) return;
    const key = 'floatingCart.collapsed';
    const toggleBtn = document.getElementById('fc-toggle');

    function applyState(){
      const collapsed = localStorage.getItem(key) === '1';
      panel.classList.toggle('collapsed', collapsed);
      // Icon rotation handled via CSS
    }
    toggleBtn?.addEventListener('click', ()=>{
      const collapsed = !(localStorage.getItem(key) === '1');
      localStorage.setItem(key, collapsed ? '1' : '0');
      applyState();
    });
    applyState();

    // AJAX qty update
    const tokenEl = document.querySelector('meta[name="csrf-token"]');
    const csrf = tokenEl ? tokenEl.getAttribute('content') : '';
    panel.querySelectorAll('form.fc-update').forEach(form => {
      const qty = form.querySelector('.fc-qty');
      const inc = form.querySelector('.fc-inc');
      const dec = form.querySelector('.fc-dec');
      function submit(){
        const fd = new FormData(form);
        fetch(form.action, { method:'POST', headers: { 'X-CSRF-TOKEN': csrf }, body: fd })
          .then(()=> location.reload())
          .catch(()=> form.submit());
      }
      inc?.addEventListener('click', ()=>{ qty.stepUp(); submit(); });
      dec?.addEventListener('click', ()=>{ qty.stepDown(); submit(); });
      qty?.addEventListener('change', submit);
    });
  })();
</script>
@endpush

@once
  @push('styles')
  <style>
    .floating-cart{ position: fixed; right: 18px; bottom: 18px; width: 380px; max-width: calc(100vw - 24px); background: rgba(255,255,255,0.98); backdrop-filter: blur(10px); border: 1px solid rgba(0,0,0,0.06); border-radius: 16px; z-index: 1060; box-shadow: 0 10px 40px rgba(0,0,0,.12); transition: box-shadow .24s ease, transform .24s ease; }
    .floating-cart .fc-header{ padding: 10px 12px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.08), rgba(118, 75, 162, 0.08)); border-bottom: 1px solid rgba(0,0,0,0.06); }
    .floating-cart .fc-body{ max-height: 50vh; overflow: auto; transition: max-height .28s cubic-bezier(0.22, 1, 0.36, 1), opacity .22s ease; opacity: 1; }
    .floating-cart .fc-items{ display: flex; flex-direction: column; gap: 10px; padding: 10px 12px; }
    .floating-cart .fc-item{ gap: 10px; padding: 8px 0; border-bottom: 1px dashed rgba(0,0,0,0.06); }
    .floating-cart .fc-item:last-child{ border-bottom: 0; }
    .floating-cart .thumb{ width: 40px; height: 40px; border-radius: 8px; overflow: hidden; background: #f3f4f6; }
    .floating-cart .thumb img{ width: 100%; height: 100%; object-fit: cover; }
    .floating-cart .meta .name{ max-width: 150px; }
    .floating-cart .fc-summary{ padding: 10px 12px; border-top: 1px solid rgba(0,0,0,0.06); background: #fafafa; }
    .floating-cart.collapsed .fc-body{ max-height: 0; opacity: 0; }
    #fc-toggle i{ transition: transform .2s ease; }
    .floating-cart.collapsed #fc-toggle i{ transform: rotate(180deg); }

    /* Mobile tidy */
    @media (max-width: 576.98px){
      .floating-cart{ left: 50%; right: auto; transform: translateX(-50%); width: calc(100vw - 16px); bottom: 10px; border-radius: 14px; }
      .floating-cart .fc-header{ padding: 8px 10px; }
      .floating-cart .fc-body{ max-height: 42vh; }
      .floating-cart .fc-items{ gap: 8px; padding: 8px 10px; }
      .floating-cart .thumb{ width: 36px; height: 36px; }
      .floating-cart .meta .name{ max-width: 120px; font-size: .9rem; }
      .floating-cart .price{ font-size: .8rem; }
      .floating-cart .line-total{ display: none; }
      .floating-cart .fc-summary{ padding: 8px 10px; }
      .floating-cart .fc-header .btn{ padding: .25rem .5rem; }
      .floating-cart .fc-header .badge{ display: none; }
    }
  </style>
  @endpush
@endonce
