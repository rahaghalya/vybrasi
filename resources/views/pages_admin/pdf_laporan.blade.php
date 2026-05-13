<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Vybrasi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #D4A373; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #111; }
        .header p { margin: 5px 0 0 0; color: #666; font-size: 11px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #fdfaf6; color: #D4A373; font-size: 11px; text-transform: uppercase; }
        
        .total-row th { background-color: #111; color: #fff; text-align: right; }
        .total-row td { background-color: #111; color: #D4A373; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN TRANSAKSI PENJUALAN KOPI</h2>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Sumber (Affiliate/Organik)</th>
                <th>Status</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse ($transaksis as $trx)
                @php
                    // Ekstrak Nama
                    $namaPelanggan = 'Pelanggan';
                    if (preg_match('/Penerima:\s*([^|]+)/', $trx->catatan, $matches)) {
                        $namaPelanggan = trim($matches[1]);
                    }
                    
                    // Hitung grand total (Hanya yang lunas/dikirim/selesai yang dihitung)
                    if(in_array($trx->status, ['shipped', 'delivered', 'selesai'])) {
                        $grandTotal += $trx->total_harga;
                    }
                @endphp
                <tr>
                    <td>{{ $trx->no_invoice }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->created_at)->translatedFormat('d M Y') }}</td>
                    <td>{{ $namaPelanggan }}</td>
                    <td>{{ $trx->kode_referal_digunakan ?? 'Organik Web' }}</td>
                    <td>{{ ucfirst($trx->status) }}</td>
                    <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data transaksi.</td>
                </tr>
            @endforelse
            
            <tr class="total-row">
                <th colspan="5">TOTAL PENDAPATAN (Pesanan Selesai & Dikirim):</th>
                <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>