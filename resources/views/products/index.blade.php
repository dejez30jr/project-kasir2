@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="fw-bold mb-1"><i class="bi bi-box-seam me-2"></i>Kelola Produk</h2>
    <p class="text-muted mb-0">Manajemen inventori dan stok</p>
  </div>
  <a href="{{ route('products.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-circle me-2"></i>Tambah Produk
  </a>
</div>

<div class="card fade-in">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover table-sm mb-0 align-middle">
        <thead>
          <tr>
            <th class="ps-4">SKU</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jenis Pack</th>
            <th>Pcs/Pack</th>
            <th>Diskon</th>
            <th>Stok</th>
            <th class="text-end pe-4">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $p)
            <tr>
              <td class="ps-4"><span class="badge bg-secondary">{{ $p->sku }}</span></td>
              <td class="fw-semibold">{{ $p->name }}</td>
              <td class="fw-semibold">Rp {{ number_format($p->price,0,',','.') }}</td>
              <td>{{ $p->pack_label }}</td>
              <td>{{ $p->pack_size }}</td>
              <td>
                @if($p->discount_type!='none')
                  <span class="badge bg-warning text-dark">
                    {{ $p->discount_type=='percent' ? $p->discount_value.'%' : 'Rp '.number_format($p->discount_value,0,',','.') }}
                  </span>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td>
                <span class="badge bg-{{ $p->stock > 10 ? 'success' : ($p->stock > 0 ? 'warning' : 'danger') }}">
                  {{ $p->stock }} pcs
                </span>
              </td>
              <td class="text-end pe-4">
                @if(in_array(auth()->user()->role, ['admin','cashier']))
                  <a href="{{ route('products.stock.form', $p) }}" class="btn btn-sm btn-outline-primary me-1" title="Tambah Stok">
                    <i class="bi bi-plus-square"></i>
                  </a>
                  <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-outline-secondary me-1" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </a>
                @endif
                @if(in_array(auth()->user()->role, ['admin','cashier']))
                  <form action="{{ route('products.destroy', $p) }}" method="POST" class="d-inline">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus produk ini?')" title="Hapus">
                      <i class="bi bi-trash3"></i>
                    </button>
                  </form>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection
