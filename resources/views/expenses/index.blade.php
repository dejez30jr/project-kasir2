@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0 fw-bold">Pengeluaran</h3>
  <a href="{{ route('expenses.create') }}" class="btn btn-outline-secondary"><i class="bi bi-plus-circle me-2"></i>Tambah</a>
</div>

<div class="card modern fade-in mb-3">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover table-sm mb-0 align-middle">
        <thead>
          <tr>
            <th class="ps-4">Tanggal</th><th>Deskripsi</th><th>Jumlah</th><th class="text-end pe-4">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($expenses as $e)
            <tr>
              <td class="ps-4">{{ $e->date->format('d M Y') }}</td>
              <td>{{ $e->description }}</td>
              <td class="fw-semibold">Rp {{ number_format($e->amount,0,',','.') }}</td>
              <td class="text-end pe-4">
                <form method="POST" action="{{ route('expenses.destroy', $e) }}" class="d-inline">@csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')"><i class="bi bi-trash3"></i></button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="d-flex justify-content-between align-items-center">
  <div class="text-muted">Total</div>
  <div class="fw-bold" style="color:#0f766e;">Rp {{ number_format($total,0,',','.') }}</div>
</div>

<div class="mt-3">{{ $expenses->links() }}</div>
@endsection
