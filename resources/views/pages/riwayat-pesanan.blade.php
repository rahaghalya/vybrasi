@extends('layouts.app')

@section('title', 'Vybrasi - Pesanan Saya')

@section('content')
<<<<<<< HEAD
<div class="riwayat-container">
    <h1 class="page-title-premium">Daftar Pesanan Saya</h1>

    <div class="riwayat-card-main">

        @forelse($pesanan as $p)
        <div class="order-item">
            <div class="order-content">
                <div class="order-header">
                    <div class="order-info">
                        <h3 class="product-name">
                            <i class="fa-solid fa-receipt" style="color: #D4A373; margin-right: 8px;"></i> 
                            {{ $p->no_invoice }}
                        </h3>
                        <p class="order-date"><i class="fa-regular fa-calendar" style="margin-right: 5px;"></i> {{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d F Y • H:i') }} WIB</p>
                    </div>
                    
                    <span class="order-status order-status--{{ strtolower($p->status) }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </div>

                <div class="order-body-flex">
                    <div class="order-price-details">
                        <span class="label-total">Total Belanja</span>
                        <p class="order-total">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="order-actions">
                        @if(in_array(strtolower($p->status), ['delivered', 'selesai', 'success']))
                            @php
                                $produk_dibeli = \Illuminate\Support\Facades\DB::table('jualan_kopi.transaksi_detail')
                                    ->where('id_transaksi', $p->id_transaksi)
                                    ->select('id_produk', 'nama_produk')
                                    ->get();
                                
                                $tgl_beli = \Carbon\Carbon::parse($p->created_at)->format('Y-m-d');
                            @endphp

                            <button class="btn-ulasan" onclick="bukaModalUlasan('{{ $p->no_invoice }}', {{ json_encode($produk_dibeli) }}, '{{ $tgl_beli }}')">
                                <i class="fa-regular fa-star"></i> Ulas Produk
                            </button>
                        @endif
                        
                        <a href="{{ route('produk') }}" class="btn-beli">
                            <i class="fa-solid fa-cart-shopping"></i> Beli Lagi
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state-pesanan">
            <div class="empty-icon-circle">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <h3>Belum ada pesanan</h3>
            <p>Anda belum pernah melakukan transaksi. Ayo mulai belanja!</p>
            <a href="{{ route('produk') }}" class="btn-beli-sekarang">Belanja Sekarang</a>
        </div>
        @endforelse
=======
<div class="vy-luxury-history-wrapper">
    <div class="editorial-history-container fade-in-up">
        
        <a href="{{ route('profil') }}" class="btn-back-hairline">
            <i class="fa-solid fa-arrow-left-long"></i>
            <span>Menu Profil</span>
        </a>

        <div class="history-header">
            <span class="badge-serif">Catatan Transaksi</span>
            <h1 class="history-title">Riwayat<br><i class="serif-accent">Pesanan.</i></h1>
            <div class="editorial-hairline"></div>
        </div>

        <div class="order-list">
            @forelse($pesanan as $p)
                <div class="order-card">
                    <div class="order-header-info">
                        <div class="order-meta">
                            <span class="order-date"><i class="fa-regular fa-calendar" style="margin-right: 5px;"></i> {{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d F Y • H:i') }} WIB</span>
                            <h3 class="order-id">{{ $p->no_invoice }}</h3>
                        </div>
                        <span class="order-status status-{{ strtolower($p->status) }}">{{ ucfirst($p->status) }}</span>
                    </div>

                    <div class="order-body-flex">
                        <div class="order-price-details">
                            <span class="label-total">Total Belanja</span>
                            <p class="order-total">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="order-actions">
                            @if(in_array(strtolower($p->status), ['delivered', 'selesai', 'success']))
                                @php
                                    $produk_dibeli = \Illuminate\Support\Facades\DB::table('jualan_kopi.transaksi_detail')
                                        ->where('id_transaksi', $p->id_transaksi)
                                        ->select('id_produk', 'nama_produk')
                                        ->get();
                                    $tgl_beli = \Carbon\Carbon::parse($p->created_at)->format('Y-m-d');
                                @endphp

                                <button class="btn-action-hairline ulasan" onclick="bukaModalUlasan('{{ $p->no_invoice }}', {{ json_encode($produk_dibeli) }}, '{{ $tgl_beli }}')">
                                    <i class="fa-regular fa-star"></i> Ulas Produk
                                </button>
                            @endif
                            
                            <a href="{{ route('produk') }}" class="btn-action-hairline beli">
                                <i class="fa-solid fa-arrow-rotate-right"></i> Beli Lagi
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state-pesanan">
                    <i class="fa-solid fa-receipt"></i>
                    <h3>Belum ada pesanan</h3>
                    <p>Anda belum pernah melakukan transaksi. Ayo mulai belanja!</p>
                    <a href="{{ route('produk') }}" class="btn-action-hairline">
                        Jelajahi Katalog <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>
            @endforelse
        </div>
>>>>>>> frontend-ui

    </div>
</div>

<<<<<<< HEAD
{{-- MODAL ULASAN PRODUK PINTAR --}}
=======
{{-- MODAL ULASAN PRODUK (EDITORIAL POP-UP) --}}
>>>>>>> frontend-ui
<div class="modal-overlay" id="modalUlasan">
    <div class="modal-ulasan-card">
        <button class="btn-close-modal" onclick="tutupModalUlasan()">&times;</button>

        <div class="modal-header">
<<<<<<< HEAD
            <h2>Ulas Kualitas Produk</h2>
            <p style="color: #888; font-size: 14px; margin-top: 5px;">Bantu pelanggan lain mengetahui kualitas produk kami.</p>
        </div>

        <form action="{{ route('testimoni.store') }}" method="POST" class="form-ulasan-grid">
            @csrf
            {{-- Dipaksa otomatis masuk sebagai ulasan produk --}}
            <input type="hidden" name="jenis_ulasan" value="produk">

            <div class="form-left">
                
                {{-- Dropdown Pilih Produk (Sekarang Langsung Terbuka) --}}
                <div class="input-group" style="background: #fdfaf6; padding: 12px; border-radius: 8px; border: 1px dashed #D4A373;">
                    <label style="color: #D4A373; font-weight: 700;">Pilih Produk yang Diulas <span style="color: red;">*</span></label>
                    <select name="id_produk" id="select_produk_ulasan" required class="input-premium" style="margin-top: 5px; border-color: #eaddcf;">
                        <option value="">-- Pilih Produk --</option>
                    </select>
                </div>

                <div class="input-group" style="margin-top: 15px;">
                    <label>Nama Anda</label>
                    <input type="text" name="nama" value="{{ auth()->user()->full_name ?? '' }}" placeholder="Masukkan nama" required class="input-premium">
                </div>

                <div class="input-group" style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label>No. Invoice</label>
                        <input type="text" name="invoice" id="invoice_ulasan" readonly class="input-premium" style="background: #f5f5f5; color: #888 !important;">
                    </div>
                    <div style="flex: 1;">
                        <label>Tgl. Pembelian</label>
                        <input type="date" name="tanggal" id="tanggal_ulasan" readonly required class="input-premium" style="background: #f5f5f5; color: #888 !important;">
                    </div>
                </div>
            </div>

            <div class="form-right">
                <div class="input-group h-100">
                    <label>Ulasan Produk</label>
                    <div class="ulasan-box-premium">
                        <textarea name="ulasan_teks" placeholder="Ceritakan kualitas rasa, aroma, atau kemasan produk ini..." required></textarea>

                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" required><label for="star5">★</label>
                            <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                            <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                            <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-kirim-submit">
                    <i class="fa-solid fa-paper-plane" style="margin-right: 8px;"></i> Kirim Ulasan
                </button>
            </div>
=======
            <h2>Ulas Produk</h2>
            <p>Bantu kami menjaga kualitas simfoni rasa Vybrasi.</p>
        </div>

        <form action="{{ route('testimoni.store') }}" method="POST" class="form-ulasan-col">
            @csrf
            <input type="hidden" name="jenis_ulasan" value="produk">
            <input type="hidden" name="invoice" id="invoice_ulasan">
            <input type="hidden" name="tanggal" id="tanggal_ulasan">

            <div class="input-group">
                <label>Pilih Produk <span style="color: red;">*</span></label>
                <select name="id_produk" id="select_produk_ulasan" required class="input-premium">
                    <option value="">-- Kurasi Pilihan Anda --</option>
                </select>
            </div>

            <div class="input-group">
                <label>Nama Anda</label>
                <input type="text" name="nama" value="{{ auth()->user()->full_name ?? '' }}" placeholder="Masukkan nama" required class="input-premium">
            </div>

            <div class="input-group">
                <label>Cerita Anda</label>
                <div class="ulasan-box-premium">
                    <textarea name="ulasan_teks" placeholder="Bagaimana rasa, aroma, atau pengalaman Anda dengan produk ini?" required></textarea>
                </div>
            </div>

            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5" required><label for="star5">★</label>
                <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
            </div>

            <button type="submit" class="btn-kirim-submit">
                Kirim Jejak Rasa
            </button>
>>>>>>> frontend-ui
        </form>
    </div>
</div>

<div id="custom-toast" class="custom-toast">
    <i class="fa-solid fa-circle-check"></i>
    <span id="toast-message">Pesan notifikasi di sini.</span>
</div>

<<<<<<< HEAD
<style>
    /* CSS tetap sama dengan sebelumnya (Premium Dark Support) */
    .riwayat-container { max-width: 900px; margin: 0 auto; padding: 20px 15px; }
    .page-title-premium { text-align: center; color: #2c2c2c; font-weight: 800; font-size: 28px; margin-bottom: 40px; letter-spacing: 0.5px; }
    .order-item { background: #ffffff; border-radius: 16px; padding: 24px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .order-item:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
    .order-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px dashed #eaeaea; padding-bottom: 15px; margin-bottom: 18px; }
    .product-name { margin: 0 0 6px 0; font-size: 18px; color: #333; font-weight: 700; }
    .order-date { margin: 0; color: #888; font-size: 13px; }
    .order-status { padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; letter-spacing: 0.3px; }
    .order-status--pending, .order-status--menunggu { background: #fff8e1; color: #f57c00; border: 1px solid #ffe0b2; }
    .order-status--delivered, .order-status--selesai, .order-status--success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
    .order-body-flex { display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 15px; }
    .order-total { margin: 5px 0 0 0; font-size: 22px; font-weight: 800; color: #D4A373; }
    .order-actions { display: flex; gap: 10px; }
    .btn-ulasan { background: #fff; border: 1.5px solid #D4A373; color: #D4A373; padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 14px; cursor: pointer; transition: 0.3s; }
    .btn-beli { background: #D4A373; border: 1.5px solid #D4A373; color: #fff; padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 14px; text-decoration: none; transition: 0.3s; display: inline-flex; align-items: center; gap: 6px; }
    .input-premium { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0; outline: none; background: #fff; color: #333 !important; }
    .ulasan-box-premium { background: #fff; border: 1px solid #e0e0e0; border-radius: 12px; padding: 15px; height: calc(100% - 25px); display: flex; flex-direction: column; }
    .ulasan-box-premium textarea { width: 100%; flex: 1; border: none; outline: none; resize: none; color: #333 !important; font-size: 14px; }
    .btn-kirim-submit { background: #D4A373; color: white; border: none; padding: 15px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; width: 100%; margin-top: 15px; transition: 0.3s; }
    .star-rating input { display: none; }
    .star-rating label { color: #e0e0e0; font-size: 28px; cursor: pointer; padding: 0 2px; }
    .star-rating input:checked ~ label, .star-rating label:hover, .star-rating label:hover ~ label { color: #FFD700; }
    .custom-toast { display: none; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background: #28a745; color: white; padding: 12px 25px; border-radius: 30px; z-index: 10000; font-weight: bold; align-items: center; gap: 8px; }
</style>

=======
>>>>>>> frontend-ui
<script>
    function bukaModalUlasan(noInvoice, produkList, tglBeli) {
        const modal = document.getElementById('modalUlasan');
        const inputInvoice = document.getElementById('invoice_ulasan');
        const inputTanggal = document.getElementById('tanggal_ulasan');
        const selectProduk = document.getElementById('select_produk_ulasan');

        if (inputInvoice) inputInvoice.value = noInvoice;
        if (inputTanggal) inputTanggal.value = tglBeli;
        
<<<<<<< HEAD
        selectProduk.innerHTML = '<option value="">-- Pilih Produk --</option>';
=======
        selectProduk.innerHTML = '<option value="">-- Kurasi Pilihan Anda --</option>';
>>>>>>> frontend-ui
        if(produkList && produkList.length > 0) {
            produkList.forEach(function(produk) {
                let option = document.createElement('option');
                option.value = produk.id_produk;
                option.text = produk.nama_produk;
                selectProduk.appendChild(option);
            });
        }

<<<<<<< HEAD
        modal.style.display = 'flex';
    }

    function tutupModalUlasan() {
        document.getElementById('modalUlasan').style.display = 'none';
=======
        modal.classList.add('active');
    }

    function tutupModalUlasan() {
        document.getElementById('modalUlasan').classList.remove('active');
>>>>>>> frontend-ui
    }

    window.onclick = function(event) {
        const modal = document.getElementById('modalUlasan');
        if (event.target == modal) tutupModalUlasan();
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('custom-toast');
            document.getElementById('toast-message').textContent = "{{ session('success') }}";
            toast.style.display = 'flex';
            setTimeout(() => { toast.style.display = 'none'; }, 4000);
        });
    @endif
</script>
@endsection