@extends('layouts.app')

@section('content')
<div class="card modern fade-in" style="max-width: 720px;">
  <div class="card-body p-4">
    <h4 class="fw-bold mb-3"><i class="bi bi-cash-coin me-2"></i>Tambah Pengeluaran</h4>
    <form method="POST" action="{{ route('expenses.store') }}">@csrf
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Tanggal</label>
          <input type="date" name="date" class="form-control" required>
        </div>
        <div class="col-md-8">
          <label class="form-label">Deskripsi</label>
          <input type="text" name="description" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jumlah</label>
          <input type="number" name="amount" class="form-control" min="0" step="0.01" required>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-success px-4">Simpan</button>
        <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
