@extends('layouts.admin')

@section('title', 'Beranda Utama')

@section('content')
<h2 class="main-title">Beranda Utama</h2>

<div class="dashboard-grid">
    
    <div class="card">
        <div class="card-header">RINGKASAN PENJUALAN</div>
        <div class="card-body kpi-card-body">
            <div class="kpi-block">
                <p class="kpi-label">Pendapatan Hari Ini</p>
                <h3 class="kpi-value text-gold">Rp 200.000</h3>
                <p class="kpi-subtext">Total Pesanan: <strong>8</strong></p>
            </div>
            <div class="kpi-divider"></div>
            <div class="kpi-block">
                <p class="kpi-label">Pendapatan Minggu Ini</p>
                <h3 class="kpi-value text-gold">Rp 1.400.000</h3>
                <p class="kpi-subtext">Total Pesanan: <strong>56</strong></p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">RINGKASAN PRODUK</div>
        <div class="card-body kpi-card-body">
            
            <div class="kpi-block">
                <p class="kpi-label">Produk Terlaris</p>
                <div class="product-highlight">
                    <img src="{{ asset('images/kopi-1.jpg') }}" alt="Kopi Arabica" class="product-img">
                    <div style="flex: 1;">
                        <h3 class="kpi-value text-dark">Kopi Arabica</h3>
                        <p class="kpi-subtext">120 Terjual Minggu Ini</p>
                        <a href="{{ route('admin.produk.edit', ['id' => 1]) }}" class="link-view-product">
                            <i class="fas fa-external-link-alt"></i> Lihat Produk
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="kpi-divider"></div>
            
            <div class="kpi-block">
                <p class="kpi-label">Peringatan Stok</p>
                <h3 class="kpi-value text-alert">5 Item Produk</h3>
                <p class="kpi-subtext">Stok menipis, butuh restock segera.</p>
                <a href="{{ route('admin.produk') }}?filter=low_stock" class="link-view-product" style="color: #C25953; font-weight: 700; margin-top: 12px;">
                    Lihat Produk Menipis <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            
        </div>
    </div>

    <div class="card">
        <div class="card-header header-with-action">
            <span>STATUS PENGIRIMAN</span>
            <a href="{{ route('admin.pengiriman') }}" class="link-view-all">Lihat Semua <i class="fas fa-chevron-right"></i></a>
        </div>
        <div class="card-body kpi-card-body">
            <div class="kpi-block">
                <p class="kpi-label">Sedang Dikirim</p>
                <div class="kpi-icon-value">
                    <i class="fas fa-truck"></i>
                    <h3 class="kpi-value text-gold">18 <span class="kpi-unit">Pesanan</span></h3>
                </div>
            </div>
            <div class="kpi-divider"></div>
            <div class="kpi-block">
                <p class="kpi-label">Tiba di Tujuan</p>
                <div class="kpi-icon-value">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3 class="kpi-value text-gold">9 <span class="kpi-unit">Pesanan</span></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header header-with-action">
            <span>PESANAN TERBARU</span>
            <a href="{{ route('admin.pesanan_baru') }}" class="link-view-all">Lihat Semua <i class="fas fa-chevron-right"></i></a>
        </div>
        <div class="card-body p-0"> 
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Nama Pelanggan</th>
                        <th>Produk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="order-id">#VFD-6346</td>
                        <td>A</td>
                        <td>Kopi Arabica</td>
                        <td class="order-status">
                            <span class="status-badge badge-dikirim">Dikirim</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="order-id">#VFD-6347</td>
                        <td>B</td>
                        <td>Gula Aren</td>
                        <td class="order-status">
                            <span class="status-badge badge-diproses">Diproses</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-full-width" style="grid-column: span 2;">
        <div class="card-header">
            LOG AKTIVITAS TERBARU
        </div>
        <div class="log-list">
            @for ($i = 0; $i < 5; $i++)
            <div class="log-item">
                <span class="log-desc">Memperbarui Stok Kopi Arabica</span>
                <span class="log-time">5 mnt lalu</span>
            </div>
            @endfor
        </div>
    </div>

</div>
@endsection