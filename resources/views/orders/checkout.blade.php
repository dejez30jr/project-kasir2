@extends('layouts.app')

@section('content')
<h3 class="mb-3">Checkout</h3>
<form method="POST" action="{{ route('checkout.process') }}">@csrf
  <div class="mb-3">
    <label class="form-label">Tipe Belanja</label>
    <select name="order_type" class="form-select" id="order_type">
      <option value="in_store">Sudah di Toko</option>
      <option value="pickup_later">Ambil Nanti</option>
    </select>
  </div>
  <div class="mb-3" id="pickup_group" style="display:none;">
    <label class="form-label">Jam Ambil</label>
    <input type="datetime-local" name="pickup_at" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Metode Pembayaran</label>
    <div class="d-flex gap-3 align-items-center flex-wrap">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="payment_method" id="pay_cash" value="cash" checked>
        <label class="form-check-label" for="pay_cash">Cash</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="payment_method" id="pay_transfer" value="transfer">
        <label class="form-check-label" for="pay_transfer">Transfer</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="payment_method" id="pay_qris" value="qris">
        <label class="form-check-label" for="pay_qris">QRIS</label>
      </div>
    </div>
  </div>
  <div class="mb-3" id="transfer_box" style="display:none;">
    <div class="card modern">
      <div class="card-body text-center">
        <p class="text-muted mb-2">Silakan lakukan transfer ke rekening berikut:</p>
        <div class="p-3 rounded-3" style="background:#f8fafc;">
          <div class="fw-bold">BCA - 1234567890</div>
          <div>a.n. Toko Anda</div>
        </div>
        <p class="text-muted mt-2" style="font-size: .9rem;">Setelah transfer, kasir akan mengonfirmasi pembayaran dan struk bisa dicetak.</p>
      </div>
    </div>
  </div>
  <button class="btn btn-primary">Selesaikan Transaksi</button>
</form>
<script>
const select = document.getElementById('order_type');
const group = document.getElementById('pickup_group');
function toggle(){ group.style.display = select.value==='pickup_later' ? 'block' : 'none'; }
select.addEventListener('change', toggle);
window.addEventListener('DOMContentLoaded', toggle);
const payCash = document.getElementById('pay_cash');
const payTransfer = document.getElementById('pay_transfer');
const payQris = document.getElementById('pay_qris');
const transferBox = document.getElementById('transfer_box');
function toggleTransfer(){ transferBox.style.display = payTransfer.checked ? 'block' : 'none'; }
;[payCash,payTransfer,payQris].forEach(el=> el.addEventListener('change', toggleTransfer));
window.addEventListener('DOMContentLoaded', toggleTransfer);
</script>
@endsection
