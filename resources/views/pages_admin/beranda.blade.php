@extends('layouts.admin')

@section('title', 'Beranda Utama')

@section('content')
<h2 class="main-title">Beranda Utama</h2>

<div class="dashboard-grid">
    <div class="card">
        <div class="card-header">RINGKASAN PENJUALAN</div>
        <div class="card-body">
            <p><strong>RP. 200.000</strong> (Hari Ini)</p>
            <p><small>Pesanan Hari Ini : 8</small></p>
            <br>
            <p><strong>RP. 1.400.000</strong> (Minggu Ini)</p>
            <p><small>Pesanan Minggu Ini : 56</small></p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">RINGKASAN PRODUK</div>
        <div class="card-body">
            <p>Produk Terlaris: <strong>Kopi Arabica</strong></p>
            <p>Stok Menipis: <span style="color: red;">5 Item Produk</span></p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">STATUS PENGIRIMAN</div>
        <div class="card-body">
            <p><i class="fas fa-truck"></i> Sedang Dikirim: 18</p>
            <p><i class="fas fa-map-marker-alt"></i> Tiba di Tujuan: 9</p>
        </div>
    </div>

    <div class="card" style="grid-column: span 2;">
        <div class="card-header">LOG AKTIVITAS TERBARU</div>
        <div class="log-list">
            @for ($i = 0; $i < 5; $i++)
            <div class="log-item">
                Memperbarui Stok Kopi Arabica (5 mnt lalu)
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection