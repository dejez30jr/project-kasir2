<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
 body{ font-family: DejaVu Sans, sans-serif; font-size:12px; }
 table{ width:100%; border-collapse: collapse; }
 th,td{ border:1px solid #aaa; padding:6px; }
 th{ background:#eee; }
 h3{ margin:0 0 8px; }
</style>
</head>
<body>
  <h3>Laporan Penjualan</h3>
  <div>Periode: {{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}</div>
  <table>
    <thead><tr><th>#</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th></tr></thead>
    <tbody>
      @foreach($orders as $o)
        <tr>
          <td>{{ $o->id }}</td>
          <td>{{ $o->created_at }}</td>
          <td>{{ $o->user->name }}</td>
          <td>Rp {{ number_format($o->grand_total,0,',','.') }}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="3" align="right"><strong>Pemasukan</strong></td>
        <td><strong>Rp {{ number_format($income,0,',','.') }}</strong></td>
      </tr>
      <tr>
        <td colspan="3" align="right">Pengeluaran</td>
        <td>Rp {{ number_format($expenses,0,',','.') }}</td>
      </tr>
      <tr>
        <td colspan="3" align="right">Keuntungan Bersih</td>
        <td>Rp {{ number_format($net,0,',','.') }}</td>
      </tr>
    </tbody>
  </table>
</body>
</html>