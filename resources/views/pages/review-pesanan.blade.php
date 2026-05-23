@extends('layouts.app')

@section('title', 'Vybrasi - Review Pesanan')

@section('content')
<div class="vy-luxury-review-wrapper">
    <div class="editorial-container fade-in-up">
        
        {{-- HEADER SECTION --}}
        <div class="review-header-editorial">
            <span class="badge-serif">Langkah Terakhir</span>
            <h1 class="editorial-page-title">Tinjauan<br><i class="serif-accent">Pesanan.</i></h1>
            <div class="editorial-hairline"></div>
        </div>

        {{-- INVOICE CARD --}}
        <div class="invoice-card-luxury">
            
            {{-- DAFTAR PRODUK --}}
            <div class="invoice-section">
                <h2 class="section-title-hairline">Daftar Produk</h2>
                @if(isset($cartItems) && count($cartItems) > 0)
                    @foreach($cartItems as $item)
                    <div class="invoice-row item-row">
                        <span class="invoice-value">{{ $item->nama }}</span>
                        <span class="invoice-label">{{ $item->jumlah }} pcs (Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }})</span>
                    </div>
                    @endforeach
                @else
                    <div class="invoice-row">
                        <span class="invoice-value">Produk tidak ditemukan</span>
                    </div>
                @endif
            </div>

            {{-- PENGIRIMAN --}}
            <div class="invoice-section">
                <h2 class="section-title-hairline">Pengiriman</h2>
                <div class="invoice-row">
                    <span class="invoice-label">Penerima</span>
                    <span class="invoice-value">{{ $checkoutData['nama_lengkap'] ?? '-' }}</span>
                </div>
                <div class="invoice-row">
                    <span class="invoice-label">WhatsApp</span>
                    <span class="invoice-value">{{ $checkoutData['no_wa'] ?? '-' }}</span>
                </div>
                <div class="invoice-row">
                    <span class="invoice-label">Alamat</span>
                    <span class="invoice-value text-right">
                        {{ $checkoutData['alamat'] ?? '-' }},<br> {{ $checkoutData['kota'] ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- PEMBAYARAN --}}
            <div class="invoice-section">
                <h2 class="section-title-hairline">Pembayaran</h2>
                <div class="invoice-row">
                    <span class="invoice-label">Metode</span>
                    <span class="invoice-value uppercase-text">
                        {{ $paymentMethod == 'qris' ? 'QRIS (E-Wallet)' : 'Transfer Bank ' . $paymentMethod }}
                    </span>
                </div>
                <div class="invoice-row">
                    <span class="invoice-label">Subtotal Produk</span>
                    <span class="invoice-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="invoice-row">
                    <span class="invoice-label">Ongkir</span>
                    <span class="invoice-value">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- TOTAL BAYAR --}}
            <div class="invoice-total-box">
                <span class="total-label">Total Bayar</span>
                <span class="total-amount">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

        </div>

        {{-- ACTIONS BUTTON --}}
        <div class="review-actions">
            <a href="{{ route('pembayaran.metode') }}" class="btn-kembali">
                <i class="fa-solid fa-arrow-left-long"></i> Kembali
            </a>
            
            <form action="{{ route('pesanan.konfirmasi') }}" method="POST" id="form-konfirmasi" class="form-action-wrapper">
                @csrf
                <button type="submit" class="btn-review" id="btn-konfirmasi">
                    Konfirmasi Pesanan <i class="fa-solid fa-check"></i>
                </button>
            </form>
        </div>

    </div>
</div>

<script>
    document.getElementById('form-konfirmasi').addEventListener('submit', function() {
        const btn = document.getElementById('btn-konfirmasi');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
        btn.style.pointerEvents = 'none';
    });
</script>
@endsection