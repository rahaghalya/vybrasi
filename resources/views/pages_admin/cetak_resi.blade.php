<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Resi - {{ $transaksi->no_invoice }}</title>
    <style>
        /* CSS Khusus Print (Hitam Putih, Rapi, Minimalis) */
        body { font-family: 'Courier New', Courier, monospace, sans-serif; color: #000; background: #ddd; margin: 0; padding: 20px; display: flex; justify-content: center; }
        
        .label-container { background: #fff; width: 100%; max-width: 10cm; /* Ukuran standard resi thermal */ padding: 15px; border: 2px dashed #333; }
        
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 900; letter-spacing: 2px; }
        .header p { margin: 2px 0 0 0; font-size: 12px; }

        .barcode-area { text-align: center; margin: 15px 0; }
        .barcode-area > div { display: inline-block; } /* Agar barcode ke tengah */
        .barcode-text { font-size: 14px; font-weight: bold; letter-spacing: 1px; margin-top: 5px; }

        .section-title { font-size: 12px; font-weight: bold; margin: 15px 0 5px 0; text-transform: uppercase; background: #000; color: #fff; padding: 3px 5px; display: inline-block; }
        
        .info-table { width: 100%; font-size: 13px; border-collapse: collapse; }
        .info-table td { padding: 3px 0; vertical-align: top; }
        .info-table td:first-child { width: 80px; font-weight: bold; }

        .item-table { width: 100%; font-size: 12px; border-collapse: collapse; margin-top: 10px; }
        .item-table th, .item-table td { border: 1px solid #000; padding: 5px; text-align: left; }
        .item-table th { background: #eee; }

        .footer { margin-top: 20px; font-size: 10px; text-align: center; border-top: 1px dashed #000; padding-top: 10px; }

        .no-print { text-align: center; margin-bottom: 20px; }
        .btn-print { background: #111; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-family: sans-serif; font-weight: bold; display: inline-block; cursor: pointer; border: none; }

        /* Sembunyikan elemen background saat nge-print */
        @media print {
            body { background: #fff; padding: 0; }
            .label-container { border: none; max-width: 100%; padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
        
        <div class="no-print">
            <button onclick="window.print()" class="btn-print">🖨️ Cetak Resi Sekarang</button>
            <br><br>
            <a href="{{ route('admin.pengiriman') }}" style="color: #555; text-decoration: none; font-family: sans-serif; font-size: 14px;">🔙 Kembali ke Pengiriman</a>
        </div>

        <div class="label-container">
            <div class="header">
                <h1>VYBRASI COFFEE</h1>
                <p>Specialty Coffee & Roastery</p>
            </div>

           <div class="barcode-area" style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; margin: 20px 0;">
                
                <div style="max-width: 100%; overflow: hidden; display: flex; justify-content: center;">
                    {!! DNS1D::getBarcodeHTML($transaksi->no_invoice, 'C39', 1.2, 60) !!}
                </div>
                
                <div class="barcode-text" style="font-size: 15px; font-weight: 900; letter-spacing: 1px; margin-top: 5px; text-align: center;">
                    {{ $transaksi->no_invoice }}
                </div>
                
            </div>

            <div class="section-title">PENERIMA</div>
            <table class="info-table">
                <tr><td>Nama</td><td>: {{ $pelanggan->nama }}</td></tr>
                <tr><td>Telepon</td><td>: {{ $pelanggan->telepon }}</td></tr>
                <tr><td>Alamat</td><td>: {{ $pelanggan->alamat }}</td></tr>
            </table>

            <div class="section-title">PENGIRIM</div>
            <table class="info-table">
                <tr><td>Nama</td><td>: Vybrasi Official</td></tr>
                <tr><td>Telepon</td><td>: 083114459227</td></tr>
            </table>

            <div class="section-title">ISI PAKET</div>
            <table class="item-table">
                <thead>
                    <tr>
                        <th>QTY</th>
                        <th>NAMA PRODUK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $item)
                    <tr>
                        <td style="text-align: center; font-weight: bold;">{{ $item->jumlah }}x</td>
                        <td>{{ $item->nama_produk }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="footer">
                ** Jangan dibanting! Produk mudah pecah (Kopi/Cairan). **<br>
                Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>