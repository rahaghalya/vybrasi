@extends('layouts.app')

@section('title', 'Vybrasi - Pesanan Saya')

@section('content')
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

    </div>
</div>

{{-- MODAL ULASAN PRODUK (EDITORIAL POP-UP) --}}
<div class="modal-overlay" id="modalUlasan">
    <div class="modal-ulasan-card">
        <button class="btn-close-modal" onclick="tutupModalUlasan()">&times;</button>

        <div class="modal-header">
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
        </form>
    </div>
</div>

<div id="custom-toast" class="custom-toast">
    <i class="fa-solid fa-circle-check"></i>
    <span id="toast-message">Pesan notifikasi di sini.</span>
</div>

<script>
    function bukaModalUlasan(noInvoice, produkList, tglBeli) {
        const modal = document.getElementById('modalUlasan');
        const inputInvoice = document.getElementById('invoice_ulasan');
        const inputTanggal = document.getElementById('tanggal_ulasan');
        const selectProduk = document.getElementById('select_produk_ulasan');

        if (inputInvoice) inputInvoice.value = noInvoice;
        if (inputTanggal) inputTanggal.value = tglBeli;
        
        selectProduk.innerHTML = '<option value="">-- Kurasi Pilihan Anda --</option>';
        if(produkList && produkList.length > 0) {
            produkList.forEach(function(produk) {
                let option = document.createElement('option');
                option.value = produk.id_produk;
                option.text = produk.nama_produk;
                selectProduk.appendChild(option);
            });
        }

        modal.classList.add('active');
    }

    function tutupModalUlasan() {
        document.getElementById('modalUlasan').classList.remove('active');
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

    @if(session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('custom-toast');
            toast.style.background = '#c0392b';
            document.getElementById('toast-message').textContent = "{{ session('error') }}";
            toast.style.display = 'flex';
            setTimeout(() => { toast.style.display = 'none'; }, 4000);
        });
    @endif
</script>
@endsection