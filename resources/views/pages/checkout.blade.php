@extends('layouts.app')

<<<<<<< HEAD
@section('title', 'Vybrasi - Detail Pemesanan')

@section('content')
<div class="checkout-container">
    <div class="checkout-card">
        
        <div class="checkout-left">
            <h2 class="checkout-title">Detail Pemesanan</h2>
            
            @if(isset($cartItems) && count($cartItems) > 0)
                <div class="checkout-product-list" style="max-height: 400px; overflow-y: auto; padding-right: 10px;">
                    @foreach($cartItems as $item)
                        <div class="checkout-item" style="display: flex; gap: 15px; margin-bottom: 20px; border-bottom: 1px dashed #eee; padding-bottom: 15px;">
                            <div class="checkout-img-wrapper" style="width: 80px; height: 80px; flex-shrink: 0;">
                                <img src="{{ $item->gambar_utama ? $item->gambar_utama : asset('images/kopi-arabica.png') }}" alt="{{ $item->nama }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                            </div>
                            
                            <div class="checkout-product-info" style="flex-grow: 1;">
                                <h3 style="margin: 0 0 5px 0; font-size: 16px; color: #333;">{{ $item->nama }}</h3>
                                <p style="margin: 0; font-size: 13px; color: #666;">{{ $item->berat_gram }}gr | Qty: <strong>{{ $item->jumlah }} pcs</strong></p>
                                <p style="margin: 5px 0 0 0; font-weight: bold; color: #D4A373;">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <hr class="checkout-divider">
                
                <div class="checkout-summary">
                    <div class="summary-row">
                        <span>Total Produk ({{ $cartItems->sum('jumlah') }} Item)</span>
                        <span id="summary-product-price">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        <span id="summary-ongkir">Rp 10.000</span>
                    </div>
                    <hr class="total-divider">
                    <div class="summary-row total-row">
                        <span>Total Pembayaran</span>
                        <span id="summary-total">Rp {{ number_format($subtotal + 10000, 0, ',', '.') }}</span>
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: 20px; color: #888;">
                    <p>Tidak ada produk yang dipilih untuk dicheckout.</p>
                    <a href="{{ route('produk') }}" style="color: #D4A373; text-decoration: none; font-weight: bold;">Belanja Sekarang</a>
                </div>
            @endif
        </div>

        <div class="checkout-right">
            <form action="{{ route('checkout.proses') }}" method="POST" class="checkout-form" id="form-checkout-data">
                @csrf
                
                <div class="form-group" style="margin-bottom: 20px; background: #fdfaf6; padding: 15px; border-radius: 8px; border: 1px solid #eaddcf;">
                    <label style="color: #D4A373; font-weight: bold;"><i class="fa-solid fa-location-dot"></i> Pilih Alamat Pengiriman</label>
                    {{-- CLASS BARU UNTUK SELECT ALAMAT AGAR TEKSNYA GELAP --}}
                    <select id="pilih-alamat" class="input-premium-select">
                        <option value="baru">+ Masukkan Alamat Baru</option>
                        @if(isset($daftarAlamat) && count($daftarAlamat) > 0)
                            @foreach($daftarAlamat as $al)
                                <option value="{{ $al->id_alamat ?? $loop->index }}" 
                                    data-kota="{{ $al->kota ?? '' }}" 
                                    data-alamat="{{ $al->alamat_lengkap ?? '' }}">
                                    Alamat {{ $loop->iteration }} ({{ $al->kota ?? 'Kota' }}) - {{ Str::limit($al->alamat_lengkap ?? '', 25) }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Penerima <span style="color: red;">*</span></label>
                    <input type="text" name="nama_lengkap" id="input-nama" class="input-premium" required placeholder="Masukkan nama penerima">
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label>No. WhatsApp <span style="color: red;">*</span></label>
                        <input type="text" name="no_wa" id="input-wa" class="input-premium" required placeholder="Contoh: 08123456789">
                    </div>
                    <div class="form-group">
                        <label>Kabupaten/Kota <span style="color: red;">*</span></label>
                        <input type="text" name="kota" id="input-kota" class="input-premium" required placeholder="Masukkan kota tujuan">
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat Lengkap <span style="color: red;">*</span></label>
                    <textarea name="alamat" rows="3" id="input-alamat" class="input-premium" required placeholder="Nama jalan, gedung, no. rumah, RT/RW"></textarea>
                </div>

                <div class="form-group" id="container-simpan-alamat" style="display: flex; align-items: center; gap: 10px; margin-top: 5px;">
                    <input type="checkbox" name="simpan_alamat" id="simpan_alamat" value="1" style="width: 18px; height: 18px; cursor: pointer;">
                    <label for="simpan_alamat" style="margin: 0; font-size: 14px; cursor: pointer; font-weight: normal; color: #333;">Simpan alamat ini untuk pembelian selanjutnya</label>
                </div>

                <div class="form-group" style="margin-top: 15px;">
                    <label>Kode Unik (Opsional)</label>
                    <input type="text" name="kode_unik" placeholder="Masukkan kode unik jika ada" class="input-premium">
                </div>

                <div class="checkout-actions" style="margin-top: 25px;">
                    <button type="button" id="btn-lanjut-bayar" class="btn-checkout-action" style="background: #D4A373; color: white; border: none; cursor: pointer; display: flex; justify-content: center; align-items: center; width: 100%; font-family: inherit; font-size: 16px; padding: 15px; border-radius: 8px; font-weight: bold; transition: 0.3s;">
                        Lanjut ke Pembayaran <i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<style>
    /* CSS BARU UNTUK INPUT AGAR TEKSNYA TERBACA DENGAN JELAS */
    .input-premium, .input-premium-select {
        width: 100%;
        padding: 12px;
        margin-top: 5px;
        border-radius: 8px;
        border: 1px solid #eaddcf;
        outline: none;
        background-color: #fff !important;
        color: #333 !important; /* Paksa warna font gelap */
        font-size: 14px;
        font-family: inherit;
        transition: 0.3s;
    }
    
    .input-premium-select {
        cursor: pointer;
    }

    /* Warna Teks Option Dropdown */
    .input-premium-select option {
        color: #333 !important;
        background-color: #fff !important;
        padding: 10px;
    }

    .input-premium:focus, .input-premium-select:focus {
        border-color: #D4A373;
        box-shadow: 0 0 0 3px rgba(212, 163, 115, 0.2);
    }
    
    .input-premium::placeholder {
        color: #aaa !important;
    }

    .btn-checkout-action:hover {
        background: #b58555 !important;
        transform: translateY(-2px);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputNama = document.getElementById('input-nama');
        const inputWa = document.getElementById('input-wa');
        const inputKota = document.getElementById('input-kota');
        const inputAlamat = document.getElementById('input-alamat');
        
        inputNama.value = "{{ auth()->user()->full_name ?? '' }}";
        inputWa.value = "{{ auth()->user()->phone ?? '' }}";

        const selectAlamat = document.getElementById('pilih-alamat');
        const containerSimpan = document.getElementById('container-simpan-alamat');
        const checkboxSimpan = document.getElementById('simpan_alamat');

        if (selectAlamat) {
            selectAlamat.addEventListener('change', function() {
                if (this.value === 'baru') {
                    inputKota.value = '';
                    inputAlamat.value = '';
                    inputKota.readOnly = false;
                    inputAlamat.readOnly = false;
                    
                    // Style kembalikan ke putih
                    inputKota.style.backgroundColor = "#fff";
                    inputAlamat.style.backgroundColor = "#fff";
                    
                    containerSimpan.style.display = 'flex';
                } else {
                    const selectedOption = this.options[this.selectedIndex];
                    inputKota.value = selectedOption.getAttribute('data-kota');
                    inputAlamat.value = selectedOption.getAttribute('data-alamat');
                    
                    inputKota.readOnly = true;
                    inputAlamat.readOnly = true;
                    
                    // Style background abu-abu penanda read-only
                    inputKota.style.backgroundColor = "#f5f5f5";
                    inputAlamat.style.backgroundColor = "#f5f5f5";
                    
                    containerSimpan.style.display = 'none';
                    checkboxSimpan.checked = false; 
                }
            });
        }

        const btnLanjutBayar = document.getElementById('btn-lanjut-bayar');
        const checkoutForm = document.getElementById('form-checkout-data');

        if (btnLanjutBayar && checkoutForm) {
            btnLanjutBayar.addEventListener('click', function() {
                inputKota.readOnly = false;
                inputAlamat.readOnly = false;
                
                if (checkoutForm.reportValidity()) {
                    checkoutForm.submit();
                }
            });
        }
=======
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
        const profileData = {
            nama: "{{ auth()->user()->full_name ?? '' }}",
            wa: "{{ auth()->user()->phone ?? '' }}",
            kota: "{{ $alamatDefault->kota ?? '' }}",
            alamat: "{{ $alamatDefault->alamat_lengkap ?? '' }}"
        };

        syncCheck.addEventListener('change', function() {
            document.getElementById('input-nama').value = this.checked ? profileData.nama : '';
            document.getElementById('input-wa').value = this.checked ? profileData.wa : '';
            document.getElementById('input-kota').value = this.checked ? profileData.kota : '';
            document.getElementById('input-alamat').value = this.checked ? profileData.alamat : '';
        });

        document.getElementById('btn-lanjut-bayar').addEventListener('click', function() {
            const form = document.getElementById('form-checkout-data');
            if (form.reportValidity()) {
                this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Memproses...</span>';
                this.style.pointerEvents = 'none';
                form.submit();
            }
        });
>>>>>>> frontend-ui
    });
</script>
@endsection