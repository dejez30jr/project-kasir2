@extends('layouts.app')

@section('content')
<div class="mb-4">
  <h2 class="fw-bold mb-1"><i class="bi bi-file-earmark-bar-graph me-2"></i>Laporan Keuangan</h2>
  <p class="text-muted">Analisis pemasukan, pengeluaran & keuntungan</p>
</div>

<div class="card modern mb-4">
  <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <div class="text-muted small mb-2 fw-semibold"><i class="bi bi-calendar-range me-2"></i>Periode Laporan</div>
      <ul class="nav nav-pills gap-2">
        <li class="nav-item"><a class="nav-link {{ $range==='weekly' ? 'active' : '' }}" href="{{ route('reports.index', ['range'=>'weekly']) }}">Mingguan</a></li>
        <li class="nav-item"><a class="nav-link {{ $range==='monthly' ? 'active' : '' }}" href="{{ route('reports.index', ['range'=>'monthly']) }}">Bulanan</a></li>
      </ul>
    </div>
    <div class="ms-auto text-end">
      <a class="btn btn-outline-secondary" href="{{ route('reports.download', ['range'=>$range]) }}">
        <i class="bi bi-file-earmark-pdf me-2"></i>Download PDF
      </a>
    </div>
  </div>
  </div>

<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="stat-card">
      <div class="mb-3">
        <div class="text-muted mb-2" style="font-size: 0.9rem; font-weight: 500;"><i class="bi bi-calendar3 me-2"></i>Periode</div>
        <div class="fw-semibold" style="color: #2c3e50;">{{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}</div>
      </div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="text-muted mb-2" style="font-size: 0.9rem; font-weight: 500;"><i class="bi bi-arrow-down-circle me-2"></i>Pemasukan</div>
          <div class="fs-3 fw-bold" style="background: var(--success-gradient); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Rp {{ number_format($income,0,',','.') }}</div>
        </div>
        <div style="width: 60px; height: 60px; background: #f3f4f6; border-radius: 16px; display: flex; align-items: center; justify-content: center;">
          <i class="bi bi-graph-up-arrow" style="font-size: 1.6rem; color: #0f766e;"></i>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="text-muted mb-2" style="font-size: 0.9rem; font-weight: 500;"><i class="bi bi-arrow-up-circle me-2"></i>Pengeluaran</div>
          <div class="fs-3 fw-bold" style="background: var(--warning-gradient); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Rp {{ number_format($expenses,0,',','.') }}</div>
        </div>
        <div style="width: 60px; height: 60px; background: #f3f4f6; border-radius: 16px; display: flex; align-items: center; justify-content: center;">
          <i class="bi bi-graph-down-arrow" style="font-size: 1.6rem; color: #92400e;"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card fade-in modern">
  <div class="card-body p-5 text-center">
    <div class="mb-3">
      <i class="bi bi-trophy" style="font-size: 3.6rem; background: linear-gradient(90deg,#f4efe3,#d9caa0); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;"></i>
    </div>
    <div class="text-muted mb-2" style="font-size: 1.1rem; font-weight: 500;">Keuntungan Bersih</div>
    <div class="display-5 fw-bold mb-3" style="background: linear-gradient(90deg,#f4efe3,#d9caa0); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">
      Rp {{ number_format($net,0,',','.') }}
    </div>
    <p class="text-muted mb-0">{{ $net >= 0 ? 'Bisnis berjalan dengan baik' : 'Perlu evaluasi pengeluaran' }}</p>
  </div>
</div>
@endsection
