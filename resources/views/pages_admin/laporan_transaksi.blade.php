@extends('layouts.admin')

@section('content')
<style>
body, .admin-container, .main-content, .content-body, section.content-body, main.main-content, .content-wrapper, .page-wrapper, .main-wrapper, .inner-content, .dashboard-content, [class*="content"], [class*="wrapper"], [class*="main"] { background: #0a0a0a !important; background-color: #0a0a0a !important; }
</style>

<div class="wrap">
    <h2 class="page-title">LAPORAN TRANSAKSI</h2>

    {{-- TOOLBAR (Pencarian & Filter) --}}
    <div class="toolbar mt-18">
        <form action="{{ route('admin.laporan') }}" method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; width: 100%; align-items: center;">
            
            <div class="search-box">
                <i class="fas fa-search mu"></i>
                <input type="text" name="search" class="inp-search" placeholder="Cari No Invoice..." value="{{ request('search') }}">
            </div>
            
            <div class="search-box" style="width: auto; padding: 0 15px;">
                <select name="status" class="inp-search" style="margin-left: 0; cursor: pointer; color: #fff;" onchange="this.form.submit()">
                    <option value="semua" style="color: #000;">Semua Status</option>
                    <option value="pending" style="color: #000;" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="shipped" style="color: #000;" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim (Shipped)</option>
                    <option value="delivered" style="color: #000;" {{ request('status') == 'delivered' ? 'selected' : '' }}>Selesai (Delivered)</option>
                </select>
            </div>

            {{-- FILTER BULANAN BARU (Desain 100% menyatu dengan tema) --}}
            <div class="search-box" style="width: auto; padding: 0 15px;">
                <i class="fas fa-calendar-alt mu" style="margin-right: 5px;"></i>
                <input type="month" name="bulan" class="inp-search" style="margin-left: 0; cursor: pointer; color: #fff;" value="{{ request('bulan') }}" onchange="this.form.submit()">
            </div>

            <a href="{{ route('admin.laporan.pdf', request()->all()) }}" class="btn-submit" style="margin-left: auto; background: #1a1a1a; border: 1px solid #333; color: #aaa; text-decoration: none;">
                <i class="fas fa-file-pdf"></i> Unduh PDF
            </a>
        </form>
    </div>

    {{-- TABEL TRANSAKSI --}}
    <div class="card mt-18">
        {{-- TAMBAHKAN WADAH SCROLL SAMPING DI SINI --}}
        <div style="overflow-x: auto;">
            <table class="dtable">
                <thead>
                    <tr>
                        <th style="white-space: nowrap;">No. Invoice</th>
                        <th style="white-space: nowrap;">Tanggal</th>
                        <th style="white-space: nowrap;">Nama Pelanggan</th>
                        <th style="white-space: nowrap;">Sumber Affiliate</th>
                        <th style="white-space: nowrap;">Total Bayar (Rp)</th>
                        <th style="white-space: nowrap;">Status Pesanan</th>
                        <th style="white-space: nowrap; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $trx)
                    <tr>
                        <td style="white-space: nowrap;"><span class="mono">{{ $trx->no_invoice }}</span></td>
                        <td class="mu" style="white-space: nowrap;">{{ \Carbon\Carbon::parse($trx->created_at)->translatedFormat('d M Y') }}</td>
                        
                        {{-- Mengekstrak nama pelanggan dari kolom catatan --}}
                        @php
                            $namaPelanggan = 'Pelanggan';
                            if (preg_match('/Penerima:\s*([^|]+)/', $trx->catatan, $matches)) {
                                $namaPelanggan = trim($matches[1]);
                            }
                        @endphp
                        <td class="fw" style="white-space: nowrap;">{{ $namaPelanggan }}</td>
                        
                        {{-- Cek apakah transaksi ini menggunakan kode referral --}}
                        <td class="gold" style="font-size: 13px; white-space: nowrap;">
                            @if($trx->kode_referal_digunakan)
                                <i class="fas fa-tag"></i> {{ $trx->kode_referal_digunakan }}
                            @else
                                <span class="mu" style="font-size: 12px;">Organik (Web)</span>
                            @endif
                        </td>
                        
                        <td class="fw" style="white-space: nowrap;">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                        
                        <td style="white-space: nowrap;">
                            @if($trx->status == 'pending')
                                <span class="bdg warn">Menunggu</span>
                            @elseif($trx->status == 'shipped')
                                <span class="bdg info">Dikirim</span>
                            @elseif($trx->status == 'delivered' || $trx->status == 'selesai')
                                <span class="bdg succ">Selesai</span>
                            @else
                                <span class="bdg" style="background: rgba(239,68,68,.1); color:#ef4444; border: 1px solid rgba(239,68,68,.3);">{{ ucfirst($trx->status) }}</span>
                            @endif
                        </td>
                        
                        <td style="white-space: nowrap; text-align: center;">
                            <a href="{{ route('admin.transaksi.detail', $trx->id_transaksi) }}" class="btn-ol">Lihat Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty">Belum ada data transaksi yang ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- FOOTER & PAGINATION --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
        <span class="mu" style="font-size: 13px;">Total: <strong>{{ $totalTransaksi }}</strong> Transaksi</span>
        <div class="pagination-wrapper">
            {{ $transaksis->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<style>
/* CORE CSS IDENTIK DENGAN AFFILIATE & BERANDA */
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease;font-family:inherit;}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.gold{color:#D4A373 !important} .mu{color:#777 !important} .fw{color:#fff !important;font-weight:600;} .mt-18{margin-top:18px}
.page-title{margin:0 0 25px 0;font-size:20px;font-weight:800;color:#fff;border-left:4px solid #D4A373;padding-left:12px;letter-spacing:1px}

/* TOOLBAR */
.toolbar{display:flex;justify-content:space-between;align-items:center;gap:15px;flex-wrap:wrap}
.search-box{display:flex;align-items:center;background:#111;border:1px solid #1e1e1e;border-radius:8px;padding:10px 15px;width:100%;max-width:300px;transition:.3s}
.search-box:focus-within{border-color:#D4A373;}
/* CSS tambahan untuk menyembunyikan icon kalender bawaan browser agar lebih rapi */
.inp-search::-webkit-calendar-picker-indicator { filter: invert(1); cursor: pointer; opacity: 0.6; }
.inp-search{background:transparent;border:none;color:#fff;outline:none;width:100%;margin-left:10px;font-size:13px;font-family:inherit}

/* TABLE & CARD */
.card{background:#111;border:1px solid #1e1e1e;border-radius:12px;overflow:hidden;box-shadow: 0 10px 30px rgba(0,0,0,0.2);}
.dtable{width:100%;border-collapse:collapse}
.dtable th{background:#0d0d0d;color:#D4A373;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:15px 20px;text-align:left;border-bottom:1px solid #1a1a1a}
.dtable td{padding:15px 20px;border-bottom:1px solid #161616;font-size:14px;color:#ccc;vertical-align:middle}
.dtable tbody tr:hover{background:#141414}

/* PENGUNCI ELEMEN AGAR TIDAK PATAH */
.mono{background:#0a0a0a;border:1px solid #1e1e1e;padding:4px 8px;border-radius:6px;font-family:monospace;color:#D4A373;font-size:13px; white-space: nowrap; display: inline-block;}
.bdg{padding:5px 12px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block; white-space: nowrap;}
.btn-ol{background:rgba(212,163,115,.05);border:1px solid rgba(212,163,115,.3);color:#D4A373;padding:7px 14px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;transition:.2s; display: inline-block; white-space: nowrap;}

.empty{text-align:center;color:#555;padding:30px;font-style:italic}

/* BUTTONS & BADGES */
.btn-submit{background:#D4A373;border:none;color:#111;padding:11px 20px;border-radius:8px;font-size:13px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:.2s}
.btn-submit:hover{background:#b58555;transform:translateY(-2px)}
.btn-ol:hover{background:#D4A373;color:#fff}
.warn{background:rgba(245,158,11,.1);color:#f59e0b;border:1px solid rgba(245,158,11,.3)}
.info{background:rgba(59,130,246,.1);color:#3b82f6;border:1px solid rgba(59,130,246,.3)}
.succ{background:rgba(16,185,129,.1);color:#10b981;border:1px solid rgba(16,185,129,.3)}

/* PAGINATION */
.pagination-wrapper nav ul.pagination { display: flex; gap: 5px; margin: 0; padding: 0; list-style: none; }
.pagination-wrapper nav ul.pagination li.page-item .page-link { background: #111; border: 1px solid #1e1e1e; color: #ccc; border-radius: 6px; padding: 6px 12px; transition: 0.2s; text-decoration: none; }
.pagination-wrapper nav ul.pagination li.page-item.active .page-link { background: #D4A373; color: #111; border-color: #D4A373; font-weight: bold;}
</style>
@endsection