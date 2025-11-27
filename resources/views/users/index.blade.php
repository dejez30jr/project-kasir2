@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h3 class="mb-1 fw-bold">Kelola Pengguna</h3>
    <p class="text-muted mb-0">Tambah, ubah peran, dan reset password pengguna.</p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-person-plus me-2"></i>Tambah Pengguna</a>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <form class="row g-2 mb-3" method="GET">
      <div class="col-md-6">
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" class="form-control" name="q" value="{{ $search }}" placeholder="Cari nama, email, atau peran...">
        </div>
      </div>
      <div class="col-md-2">
        <button class="btn btn-outline-secondary w-100"><i class="bi bi-filter me-2"></i>Filter</button>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th class="ps-4">Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Peran</th>
            <th class="text-end pe-4">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
          <tr>
            <td class="ps-4">
              <div class="fw-semibold">{{ $u->name }}</div>
              <small class="text-muted">Bergabung: {{ $u->created_at->format('d M Y') }}</small>
            </td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->phone ?: '-' }}</td>
            <td>
              @if($u->role==='admin')
                <span class="badge bg-primary">Admin</span>
              @elseif($u->role==='cashier')
                <span class="badge bg-success">Kasir</span>
              @else
                <span class="badge bg-secondary">User</span>
              @endif
            </td>
            <td class="text-end pe-4 d-flex justify-content-end gap-2">
              <a href="{{ route('users.edit', $u) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="bi bi-pencil-square"></i></a>
              <!-- Reset password dropdown -->
              <button class="btn btn-sm btn-outline-warning" data-bs-toggle="collapse" data-bs-target="#reset-{{ $u->id }}" aria-expanded="false" aria-controls="reset-{{ $u->id }}" title="Reset Password"><i class="bi bi-key"></i></button>
              <form method="POST" action="{{ route('users.destroy', $u) }}" onsubmit="return confirm('Hapus pengguna ini? Data login akan dihapus, riwayat tidak hilang.')">@csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" {{ auth()->id()===$u->id ? 'disabled title=Tidak+bisa+hapus+akun+sendiri' : '' }}><i class="bi bi-trash3"></i></button>
              </form>
            </td>
          </tr>
          <tr class="collapse" id="reset-{{ $u->id }}">
            <td colspan="5" class="ps-4 pb-3">
              <form class="row g-2 align-items-end" method="POST" action="{{ route('users.reset', $u) }}">@csrf
                <div class="col-md-3">
                  <label class="form-label">Password Baru</label>
                  <input type="password" class="form-control" name="new_password" required minlength="6">
                </div>
                <div class="col-md-3">
                  <label class="form-label">Konfirmasi Password</label>
                  <input type="password" class="form-control" name="new_password_confirmation" required minlength="6">
                </div>
                <div class="col-md-2">
                  <button class="btn btn-warning w-100"><i class="bi bi-key me-2"></i>Reset</button>
                </div>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center py-5">
              <div class="text-muted">Belum ada pengguna.</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">{{ $users->links() }}</div>
  </div>
</div>
@endsection
