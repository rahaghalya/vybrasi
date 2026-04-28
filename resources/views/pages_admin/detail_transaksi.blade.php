@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')

<style>
    .content-body { background-color: transparent !important; border: none !important; box-shadow: none !important; }
</style>

<a href="{{ url('/admin/laporan-transaksi') }}" class="btn-back"> 
    <i class="fas fa-arrow-left"></i> Kembali ke Laporan Transaksi
</a>

<div class="invoice-card">
    
    <div class="invoice-header">
        <div class="invoice-brand">
            <h1>VYBRASI COFFEE</h1>
            <p>Premium Coffee Beans & Drip Bags</p>
        </div>
        <div class="invoice-status-box">
            <h2>INVOICE #VYB-260426</h2>
            <span class="badge-status"><i class="fas fa-check-circle"></i> TRANSAKSI SELESAI</span>
            <p style="margin-top: 10px; font-size: 13px; color: #8C7A70;">Tanggal: 26 April 2026</p>
        </div>
    </div>

    <div class="invoice-info-grid">
        <div class="info-block">
            <h4>Informasi Pelanggan</h4>
            <p>Fadil Prasetyo</p>
            <p style="font-weight: normal;">fdl@gmail.com</p>
            <p style="font-weight: normal;">0812-3456-7890</p>
        </div>
        <div class="info-block">
            <h4>Alamat Pengiriman</h4>
            <p>Jl. Example</p>
            <p style="font-weight: normal;">Kabupaten Surabaya</p>
            <p style="font-weight: normal;">Jawa Timur, 61211</p>
        </div>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th style="width: 50%;">Produk</th>
                <th style="text-align: center;">Harga</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Kopi Arabica Gayo (250g)</strong><br><span style="font-size: 12px; color: #8C7A70;">Roasted Beans</span></td>
                <td style="text-align: center;">Rp 85.000</td>
                <td style="text-align: center;">2</td>
                <td style="text-align: right;">Rp 170.000</td>
            </tr>
            <tr>
                <td><strong>Vybrasi Signature Drip Bag</strong><br><span style="font-size: 12px; color: #8C7A70;">Isi 5 Sachet</span></td>
                <td style="text-align: center;">Rp 45.000</td>
                <td style="text-align: center;">1</td>
                <td style="text-align: right;">Rp 45.000</td>
            </tr>
        </tbody>
    </table>

    <div class="invoice-summary">
        <div class="summary-box">
            <div class="summary-row">
                <span>Subtotal Produk</span>
                <span>Rp 215.000</span>
            </div>
            <div class="summary-row">
                <span>Biaya Pengiriman</span>
                <span>Rp 15.000</span>
            </div>
            <div class="summary-row" style="color: #27ae60;">
                <span>Diskon Affiliate (AF-001)</span>
                <span>- Rp 10.000</span>
            </div>
            <div class="summary-row grand-total">
                <span>Total Pembayaran</span>
                <span>Rp 220.000</span>
            </div>

        </div>
    </div>

</div>

@endsection