@extends('layouts.admin')

@section('content')
{{-- Override Background Putih Parent --}}
<style>
body, .admin-container, .main-content, .content-body, section.content-body, main.main-content, .content-wrapper, .page-wrapper, .main-wrapper, .inner-content, .dashboard-content, [class*="content"], [class*="wrapper"], [class*="main"] { background: #0a0a0a !important; background-color: #0a0a0a !important; }
aside, .sidebar, [class*="sidebar"] { background: unset !important; background-color: unset !important; }
</style>

<div class="wrap">
    
    <div style="margin-bottom: 15px;">
        <a href="{{ route('admin.laporan') }}" class="btn-back"> 
            <i class="fas fa-arrow-left"></i> Kembali ke Laporan Transaksi
        </a>
    </div>

    <div class="invoice-card">
        
        <div class="inv-header">
            <div>
                <h1 class="inv-brand">VYBRASI COFFEE</h1>
                <p class="inv-sub">Premium Coffee Beans & Drip Bags</p>
            </div>
            <div class="inv-status">
                <h2 class="inv-no">INVOICE #{{ $transaksi->no_invoice }}</h2>
                
                @if($transaksi->status == 'pending')
                    <span class="bdg warn"><i class="fas fa-clock"></i> MENUNGGU PEMBAYARAN</span>
                @elseif($transaksi->status == 'shipped')
                    <span class="bdg info"><i class="fas fa-truck"></i> SEDANG DIKIRIM</span>
                @else
                    <span class="bdg succ"><i class="fas fa-check-circle"></i> TRANSAKSI SELESAI</span>
                @endif
                
                <p class="inv-date">Tanggal: {{ \Carbon\Carbon::parse($transaksi->created_at)->translatedFormat('d F Y - H:i') }}</p>
            </div>
        </div>

        <div class="info-grid mt-18">
            <div class="info-box">
                <h4>Informasi Pelanggan</h4>
                <p class="text-white-force" style="font-size: 15px; margin-bottom: 5px;">{{ $pelanggan->nama }}</p>
                <p class="text-muted-force"><i class="fas fa-phone fa-fw"></i> {{ $pelanggan->telepon }}</p>
                
                @if($transaksi->kode_referal_digunakan)
                    <p class="text-gold-force" style="margin-top: 10px;">
                        <i class="fas fa-tag"></i> Affiliate: <strong>{{ $transaksi->kode_referal_digunakan }}</strong>
                    </p>
                @endif
            </div>
            <div class="info-box">
                <h4>Alamat Pengiriman</h4>
                <p class="text-muted-force" style="line-height: 1.6;">{{ $pelanggan->alamat }}</p>
                
                @if($transaksi->metode_pembayaran)
                    <h4 style="margin-top: 15px;">Metode Pembayaran</h4>
                    <p class="text-white-force" style="text-transform: uppercase;">{{ str_replace('_', ' ', $transaksi->metode_pembayaran) }}</p>
                @endif
            </div>
        </div>

        <table class="inv-table mt-18">
            <thead>
                <tr>
                    <th style="width: 50%;">Produk</th>
                    <th style="text-align: center;">Harga</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $item)
                <tr>
                    <td>
                        {{-- DIJAMIN TERLIHAT PUTIH TERANG --}}
                        <strong class="text-white-force" style="font-size: 14px; display: block; margin-bottom: 3px;">
                            {{ $item->nama_produk }}
                        </strong>
                        <span class="text-muted-force" style="font-size: 11px; text-transform: uppercase;">
                            Kopi Vybrasi
                        </span>
                    </td>
                    <td class="text-muted-force" style="text-align: center;">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-muted-force" style="text-align: center;">{{ $item->jumlah }}</td>
                    <td class="text-white-force" style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="inv-summary">
            <div class="summary-box">
                <div class="sum-row">
                    <span>Subtotal Produk</span>
                    <span class="text-white-force">Rp {{ number_format($subtotalProduk, 0, ',', '.') }}</span>
                </div>
                <div class="sum-row">
                    <span>Biaya Pengiriman</span>
                    <span class="text-white-force">Rp {{ number_format($transaksi->biaya_pengiriman ?? 10000, 0, ',', '.') }}</span>
                </div>
                
                @if($transaksi->diskon > 0)
                <div class="sum-row" style="color: #4ade80;">
                    <span>Diskon</span>
                    <span>- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</span>
                </div>
                @endif
                
                <div class="sum-row grand-total">
                    <span>Total Pembayaran</span>
                    <span class="text-gold-force">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* CORE CSS */
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease;font-family:inherit;}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.gold{color:#D4A373} .mu{color:#777} .fw{color:#fff;font-weight:600;} .mt-18{margin-top:18px}

.btn-back{display:inline-flex;align-items:center;gap:8px;color:#777;font-size:13px;font-weight:600;text-decoration:none;transition:.2s}
.btn-back:hover{color:#D4A373;transform:translateX(-4px)}

/* FORCE COLOR CLASSES - ANTI GAGAL */
.text-white-force { color: #ffffff !important; font-weight: 700 !important; opacity: 1 !important; text-shadow: 0 0 1px rgba(255,255,255,0.2); }
.text-gold-force { color: #D4A373 !important; font-weight: 800 !important; opacity: 1 !important; }
.text-muted-force { color: #aaaaaa !important; opacity: 1 !important; }

/* INVOICE CARD */
.invoice-card{background:#111;border:1px solid #1e1e1e;border-radius:12px;padding:30px;box-shadow: 0 10px 30px rgba(0,0,0,0.2);}

/* HEADER */
.inv-header{display:flex;justify-content:space-between;align-items:flex-start;border-bottom:1px dashed #333;padding-bottom:20px}
.inv-brand{margin:0 0 5px;font-size:24px;font-weight:900;color:#D4A373;letter-spacing:1px}
.inv-sub{margin:0;font-size:12px;color:#666;text-transform:uppercase;letter-spacing:1px}
.inv-status{text-align:right}
.inv-no{margin:0 0 10px;font-size:18px;color:#fff;font-weight:800;font-family:monospace}
.inv-date{margin:10px 0 0;font-size:12px;color:#666}

/* INFO GRID */
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.info-box{background:#0a0a0a;border:1px solid #1a1a1a;border-radius:8px;padding:15px}
.info-box h4{margin:0 0 10px;font-size:11px;color:#888;text-transform:uppercase;letter-spacing:1px;border-bottom:1px solid #1a1a1a;padding-bottom:8px}
.info-box p{margin:0;font-size:13px;}

/* TABLE */
.inv-table{width:100%;border-collapse:collapse;border:1px solid #1a1a1a;border-radius:8px;overflow:hidden;background:#0a0a0a}
.inv-table th{background:#161616;color:#D4A373;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:15px;border-bottom:1px solid #222}
.inv-table td{padding:15px;border-bottom:1px solid #1a1a1a;font-size:13px;vertical-align:middle}
.inv-table tbody tr:hover{background:#0f0f0f}
.inv-table tbody tr:last-child td{border-bottom:none}

/* SUMMARY */
.inv-summary{display:flex;justify-content:flex-end;margin-top:20px}
.summary-box{width:100%;max-width:350px;background:#0a0a0a;border:1px solid #1a1a1a;border-radius:8px;padding:15px}
.sum-row{display:flex;justify-content:space-between;margin-bottom:10px;font-size:13px;color:#aaa}
.sum-row:last-child{margin-bottom:0}
.grand-total{border-top:1px dashed #333;padding-top:15px;margin-top:10px;font-size:16px;font-weight:800;color:#fff}

/* BADGES */
.bdg{padding:6px 12px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block;letter-spacing:.5px}
.warn{background:rgba(245,158,11,.1);color:#f59e0b;border:1px solid rgba(245,158,11,.3)}
.info{background:rgba(59,130,246,.1);color:#3b82f6;border:1px solid rgba(59,130,246,.3)}
.succ{background:rgba(16,185,129,.1);color:#4ade80;border:1px solid rgba(16,185,129,.3)}

@media(max-width:768px){
    .inv-header{flex-direction:column;gap:20px}
    .inv-status{text-align:left}
    .info-grid{grid-template-columns:1fr}
    .summary-box{max-width:100%}
}
</style>
@endsection