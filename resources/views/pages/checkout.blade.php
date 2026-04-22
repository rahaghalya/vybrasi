@extends('layouts.app')

@section('title', 'Vybrasi - Detail Pemesanan')

@section('content')
<div class="checkout-container">
    <div class="checkout-card">
        
        <div class="checkout-left">
            <h2 class="checkout-title">Detail Pemesanan</h2>
            
            <div class="checkout-img-wrapper">
                <img src="{{ asset('images/kopi-arabica.png') }}" alt="Kopi Arabica">
            </div>
            
            <div class="checkout-product-info">
                <h3>Kopi Arabica</h3>
                <p>250gr - Premium Roast</p>
            </div>
            
            <hr class="checkout-divider">
            
            <div class="checkout-summary">
                <div class="summary-row">
                    <span>Produk</span>
                    <span>Rp 50.000</span>
                </div>
                <div class="summary-row">
                    <span>Qty</span>
                    <span>1</span>
                </div>
                <div class="summary-row">
                    <span>Ongkir</span>
                    <span>Rp 10.000</span>
                </div>
                <hr class="total-divider">
                <div class="summary-row total-row">
                    <span>Total</span>
                    <span>Rp 60.000</span>
                </div>
            </div>
        </div>

        <div class="checkout-right">
            <form action="#" method="POST" class="checkout-form">
                @csrf
                
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap">
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label>No. WhatsApp</label>
                        <input type="text" name="no_wa">
                    </div>
                    <div class="form-group">
                        <label>Kabupaten/Kota</label>
                        <input type="text" name="kota">
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" rows="4"></textarea>
                </div>

                <div class="sync-profile-wrapper">
                    <span>Sesuaikan dengan Profil</span>
                    <label class="cart-checkbox">
                        <input type="checkbox" name="sync_profil">
                        <span class="checkmark-circle"></span>
                    </label>
                </div>

                <div class="form-group half-width">
                    <label>Kode Unik</label>
                    <input type="text" name="kode_unik" placeholder="masukan kode unik jika ada" class="input-kode">
                </div>

                <div class="form-group half-width">
                    <label>Jumlah</label>
                    <div class="checkout-qty-wrapper">
                        <button type="button" class="qty-btn minus"><i class="fa-solid fa-minus"></i></button>
                        <span class="qty-num">1</span>
                        <button type="button" class="qty-btn plus"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>

                <div class="checkout-actions">
                    <a href="{{ route('pembayaran.metode') }}" class="btn-checkout-action" style="text-decoration: none; display: flex; justify-content: center; align-items: center;">
                        Lanjut ke Pembayaran <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <button type="button" class="btn-checkout-action">
                        Tambah ke keranjang <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection