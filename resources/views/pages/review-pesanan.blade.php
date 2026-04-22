@extends('layouts.app')

@section('title', 'Vybrasi - Review Pesanan')

@section('content')
<div class="review-container">
    <div class="review-card">
        
        <div class="review-section">
            <h2 class="review-section-title">Produk</h2>
            <div class="review-row">
                <span class="row-label">Nama</span>
                <span class="row-value">Kopi Arabica 250gr</span>
            </div>
            <div class="review-row">
                <span class="row-label">Jumlah</span>
                <span class="row-value">1 pack</span>
            </div>
        </div>

        <div class="review-section">
            <h2 class="review-section-title">Pengiriman</h2>
            <div class="review-row">
                <span class="row-label">Penerima</span>
                <span class="row-value">Fadil Prasetyo</span>
            </div>
            <div class="review-row">
                <span class="row-label">WhatsApp</span>
                <span class="row-value">081222222</span>
            </div>
            <div class="review-row">
                <span class="row-label">Alamat</span>
                <span class="row-value">Nganjuk</span>
            </div>
        </div>

        <div class="review-section">
            <h2 class="review-section-title">Pembayaran</h2>
            <div class="review-row">
                <span class="row-label">Metode</span>
                <span class="row-value">Transfer Bank BCA</span>
            </div>
            <div class="review-row">
                <span class="row-label">Subtotal</span>
                <span class="row-value">Rp 50.000</span>
            </div>
            <div class="review-row">
                <span class="row-label">Ongkir</span>
                <span class="row-value">Rp 10.000</span>
            </div>
        </div>

        <div class="total-section">
            <div class="total-row">
                <span class="total-title">Total Bayar</span>
                <span class="total-value">Rp 60.000</span>
            </div>
        </div>

        <div class="review-actions">
            <a href="{{ route('pembayaran.metode') }}" class="btn-action-outline">
                <i class="fa-solid fa-arrow-left-long"></i> Kembali
            </a>
<a href="{{ route('pesanan.berhasil') }}" class="btn-action-solid" style="text-decoration: none; display: flex; justify-content: center; align-items: center;">
    Konfirmasi Pesanan <i class="fa-solid fa-arrow-right-long"></i>
</a>
        </div>

    </div>
</div>
@endsection