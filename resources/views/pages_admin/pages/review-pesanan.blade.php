@extends('layouts.app')

@section('title', 'Vybrasi - Review Pesanan')

@section('content')
<div class="review-container">
    <div class="review-card">
        
        <div class="review-section">
            <h2 class="review-section-title">Daftar Produk</h2>
            @if(isset($cartItems) && count($cartItems) > 0)
                @foreach($cartItems as $item)
                <div class="review-row" style="margin-bottom: 10px; border-bottom: 1px solid #f0f0f0; padding-bottom: 5px;">
                    <span class="row-label">{{ $item->nama }}</span>
                    <span class="row-value">{{ $item->jumlah }} pcs (Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }})</span>
                </div>
                @endforeach
            @else
                <div class="review-row">
                    <span class="row-value">Produk tidak ditemukan</span>
                </div>
            @endif
        </div>

        <div class="review-section">
            <h2 class="review-section-title">Pengiriman</h2>
            <div class="review-row">
                <span class="row-label">Penerima</span>
                <span class="row-value">{{ $checkoutData['nama_lengkap'] ?? '-' }}</span>
            </div>
            <div class="review-row">
                <span class="row-label">WhatsApp</span>
                <span class="row-value">{{ $checkoutData['no_wa'] ?? '-' }}</span>
            </div>
            <div class="review-row">
                <span class="row-label">Alamat</span>
                <span class="row-value" style="text-align: right;">
                    {{ $checkoutData['alamat'] ?? '-' }}, {{ $checkoutData['kota'] ?? '-' }}
                </span>
            </div>
        </div>

        <div class="review-section">
            <h2 class="review-section-title">Pembayaran</h2>
            <div class="review-row">
                <span class="row-label">Metode</span>
                <span class="row-value" style="text-transform: uppercase; font-weight: bold;">
                    {{ $paymentMethod == 'qris' ? 'QRIS (E-Wallet)' : 'Transfer Bank ' . $paymentMethod }}
                </span>
            </div>
            <div class="review-row">
                <span class="row-label">Subtotal Produk</span>
                <span class="row-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="review-row">
                <span class="row-label">Ongkir</span>
                <span class="row-value">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="total-section" style="background: #fdfaf6; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <div class="total-row" style="display: flex; justify-content: space-between; font-weight: bold; font-size: 18px;">
                <span class="total-title">Total Bayar</span>
                <span class="total-value" style="color: #D4A373;">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="review-actions" style="display: flex; gap: 10px;">
            <a href="{{ route('pembayaran.metode') }}" class="btn-action-outline" style="flex: 1; text-align: center; padding: 12px; border: 1px solid #D4A373; color: #D4A373; border-radius: 8px; text-decoration: none;">
                <i class="fa-solid fa-arrow-left-long"></i> Kembali
            </a>
            
            <form action="{{ route('pesanan.konfirmasi') }}" method="POST" style="margin: 0; flex: 2;">
                @csrf
                <button type="submit" class="btn-action-solid" style="width: 100%; background: #D4A373; color: white; padding: 12px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold;">
                    Konfirmasi Pesanan <i class="fa-solid fa-check" style="margin-left: 8px;"></i>
                </button>
            </form>
        </div>

    </div>
</div>
@endsection