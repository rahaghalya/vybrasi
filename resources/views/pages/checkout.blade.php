@extends('layouts.app')

@section('title', 'Vybrasi - Checkout')

@section('content')
<div class="vy-luxury-checkout-wrapper">
    <div class="editorial-checkout-container fade-in-up">
        
        <div class="checkout-header-editorial">
            <span class="badge-serif">Finalisasi Transaksi</span>
            <h1 class="editorial-page-title">Detail<br><i class="serif-accent">Pesanan.</i></h1>
            <div class="editorial-hairline"></div>
        </div>

        <div class="checkout-grid-layout">
            
            {{-- KOLOM KIRI: RINGKASAN --}}
            <div class="checkout-summary-column">
                <h2 class="section-title-hairline">Ringkasan Kurasi</h2>
                @if(isset($cartItems) && count($cartItems) > 0)
                    <div class="checkout-product-list">
                        @foreach($cartItems as $item)
                            <div class="checkout-item-luxury">
                                <div class="item-img-luxury">
                                    <img src="{{ $item->gambar_utama ?? asset('images/kopi-arabica.png') }}" alt="{{ $item->nama }}">
                                </div>
                                <div class="item-info-luxury">
                                    <h3>{{ $item->nama }}</h3>
                                    <p>{{ $item->berat_gram }}gr <span class="divider-dot">•</span> Qty: <strong>{{ $item->jumlah }}</strong></p>
                                    <span class="item-price-luxury">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="checkout-totals-box">
                        <div class="summary-row-hairline">
                            <span class="summary-label">Total Produk</span>
                            <span class="summary-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row-hairline">
                            <span class="summary-label">Biaya Pengiriman</span>
                            <span class="summary-value">Rp 10.000</span>
                        </div>
                        <div class="summary-grand-total">
                            <span class="grand-total-label">Total Pembayaran</span>
                            <span class="grand-total-value">Rp {{ number_format($subtotal + 10000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- KOLOM KANAN: FORM --}}
            <div class="checkout-form-column">
                <h2 class="section-title-hairline">Destinasi Pengiriman</h2>
                <form action="{{ route('checkout.proses') }}" method="POST" class="checkout-editorial-form" id="form-checkout-data">
                    @csrf
                    
                    <div class="profile-sync-toggle">
                        <label class="premium-toggle">
                            <input type="checkbox" id="sync-profile-check">
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label">Sesuaikan dengan alamat profil saya</span>
                    </div>

                    <div class="form-group-hairline">
                        <label>Nama Penerima <span class="required-asterisk">*</span></label>
                        <input type="text" name="nama_lengkap" id="input-nama" class="input-hairline" required placeholder="Nama lengkap penerima">
                    </div>

                    <div class="form-row-2">
                        <div class="form-group-hairline">
                            <label>No. WhatsApp <span class="required-asterisk">*</span></label>
                            <input type="text" name="no_wa" id="input-wa" class="input-hairline" required placeholder="Cth: 08123456789">
                        </div>
                        <div class="form-group-hairline">
                            <label>Kabupaten / Kota <span class="required-asterisk">*</span></label>
                            <input type="text" name="kota" id="input-kota" class="input-hairline" required placeholder="Kota tujuan">
                        </div>
                    </div>

                    <div class="form-group-hairline">
                        <label>Alamat Lengkap <span class="required-asterisk">*</span></label>
                        <textarea name="alamat" rows="2" id="input-alamat" class="input-hairline textarea-hairline" required placeholder="Jalan, gedung, no. rumah, RT/RW"></textarea>
                    </div>

                    <div class="checkout-actions">
                        <button type="button" id="btn-lanjut-bayar" class="btn-checkout-pill">
                            <span>Lanjut ke Pembayaran</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const syncCheck = document.getElementById('sync-profile-check');
        
        <?php
            // 1. Ambil data dengan PHP Murni (Bypass Blade Compiler)
            $alamatUtama = null;
            if (isset($daftarAlamat) && count($daftarAlamat) > 0) {
                $alamatUtama = $daftarAlamat->first();
            }

            $fullAlamat = '';
            $kotaUser = '';
            
            if ($alamatUtama) {
                $fullAlamat = $alamatUtama->alamat_lengkap . ', ' . $alamatUtama->provinsi . ' ' . $alamatUtama->kode_pos;
                $kotaUser = $alamatUtama->kota;
            }

            $namaUser = auth()->check() ? auth()->user()->full_name : '';
            $waUser = auth()->check() ? auth()->user()->phone : '';

            $dataProfilSistem = [
                'nama'   => $namaUser,
                'wa'     => $waUser,
                'kota'   => $kotaUser,
                'alamat' => $fullAlamat
            ];
        ?>

        // 2. Oper ke JavaScript menggunakan json_encode murni (Sangat Aman)
        const profileData = {!! json_encode($dataProfilSistem) !!};

        // 3. Logika Centang Alamat
        syncCheck.addEventListener('change', function() {
            document.getElementById('input-nama').value = this.checked ? profileData.nama : '';
            document.getElementById('input-wa').value = this.checked ? profileData.wa : '';
            document.getElementById('input-kota').value = this.checked ? profileData.kota : '';
            document.getElementById('input-alamat').value = this.checked ? profileData.alamat : '';
        });

        // 4. Efek Loading Tombol Lanjut Bayar
        document.getElementById('btn-lanjut-bayar').addEventListener('click', function() {
            const form = document.getElementById('form-checkout-data');
            if (form.reportValidity()) {
                this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Memproses...</span>';
                this.style.pointerEvents = 'none';
                form.submit();
            }
        });
    });
</script>
@endsection