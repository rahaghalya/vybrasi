@extends('layouts.app')

@section('title', 'Vybrasi - ' . $produk->nama)

@section('content')
<div class="editorial-detail-wrap">
    
    {{-- SISI KIRI: GAMBAR RAKSASA (STICKY) --}}
    <div class="ed-left-image">
        <img src="{{ $produk->gambar_utama ? $produk->gambar_utama : 'https://placehold.co/800x1200/1A251C/F9F6F0?text=' . urlencode($produk->nama) }}" 
             alt="{{ $produk->nama }}">
        <div class="ed-image-overlay">
            <span class="ed-badge">Single Origin Reserve</span>
        </div>
    </div>

    {{-- SISI KANAN: KONTEN & SCROLL --}}
    <div class="ed-right-content">
        <div class="ed-content-inner">
            
            {{-- Header Info --}}
            <div class="ed-header">
                <a href="{{ route('produk') }}" class="ed-back-link">
                    <i class="fa-solid fa-arrow-left-long"></i> Kembali ke Katalog
                </a>
                <h1 class="ed-title">{{ $produk->nama }}</h1>
                <h2 class="ed-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h2>
                <div class="ed-thin-line"></div>
                <p class="ed-desc">
                    {{ $produk->deskripsi_singkat ?? $produk->deskripsi_lengkap ?? 'Biji kopi pilihan terbaik, diproses dengan cermat untuk menghasilkan cita rasa kompleks, aroma harum, dan pengalaman seduh yang berkelas.' }}
                </p>
            </div>

            {{-- Fitur / Sensory Attributes --}}
            <div class="ed-features">
                <div class="ed-feat-item">
                    <i class="fa-solid fa-leaf"></i>
                    <span>100% Alami</span>
                </div>
                <div class="ed-feat-item">
                    <i class="fa-solid fa-award"></i>
                    <span>Quality First</span>
                </div>
                <div class="ed-feat-item">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span>Single Origin</span>
                </div>
            </div>

            {{-- Rating Summary Minimalis --}}
            <div class="ed-rating-box">
                <div class="ed-score-wrap">
                    <span class="ed-score">{{ $produk->ulasan->count() > 0 ? number_format($produk->ulasan->avg('rating'), 1) : '0.0' }}</span>
                    <div class="ed-stars">
                        @for($i=0; $i<5; $i++) <i class="fa-solid fa-star"></i> @endfor
                    </div>
                    <span class="ed-review-count">{{ $produk->ulasan->count() }} Ulasan</span>
                </div>
                <div class="ed-rating-bars">
                    @foreach([5 => 85, 4 => 35, 3 => 10, 2 => 5, 1 => 0] as $star => $width)
                    <div class="ed-bar-row">
                        <span>{{ $star }} <i class="fa-solid fa-star" style="font-size: 8px;"></i></span>
                        <div class="ed-bar-track"><div class="ed-bar-fill" style="width: {{ $width }}%;"></div></div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Ulasan Pelanggan --}}
            <div class="ed-reviews">
                <h3>Suara Pelanggan</h3>
                
                @forelse ($produk->ulasan as $ulasan)
                    <div class="ed-review-card">
                        <div class="ed-review-head">
                            <div class="ed-avatar">{{ substr($ulasan->user->full_name ?? 'A', 0, 1) }}</div>
                            <div class="ed-reviewer">
                                <h4>{{ $ulasan->user->full_name ?? 'Pengguna Anonim' }}</h4>
                                <span>{{ \Carbon\Carbon::parse($ulasan->created_at)->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="ed-review-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star" style="color: {{ $i <= $ulasan->rating ? '#C1A68D' : '#E2E8F0' }};"></i>
                                @endfor
                            </div>
                        </div>
                        <h5 class="ed-review-title">"{{ $ulasan->judul ?? 'Luar Biasa' }}"</h5>
                        <p class="ed-review-text">{{ $ulasan->komentar }}</p>
                        
                        @if(!empty($ulasan->gambar))
                            <div class="ed-review-img">
                                @foreach($ulasan->gambar as $img)
                                    <img src="{{ asset('storage/'.$img) }}" alt="Foto Ulasan">
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="ed-empty-review">
                        <i class="fa-regular fa-comments"></i>
                        <p>Jadilah yang pertama meninggalkan jejak rasa untuk mahakarya ini.</p>
                    </div>
                @endforelse
            </div>

        </div>

        {{-- ACTION BUTTONS STICKY BOTTOM (ULTRA-PREMIUM) --}}
        <div class="ed-action-bar">
            <form action="{{ route('keranjang.tambah') }}" method="POST" id="form-direct-cart" style="flex: 1;">
                @csrf
                <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                <input type="hidden" name="jumlah" value="1">
                
                {{-- Tombol Keranjang: Efek Sweep-Up --}}
                <button type="button" id="btn-add-cart-direct" class="btn-vip-outline">
                    <span class="btn-text-vip">Tambahkan ke Keranjang</span>
                    <div class="sweep-fill"></div>
                </button>
            </form>

            {{-- Tombol Beli: Efek Slide Arrow --}}
            <button type="button" id="btn-trigger-checkout" class="btn-vip-solid">
                <span class="btn-text-vip">Beli Sekarang</span>
                <span class="btn-icon-vip"><i class="fa-solid fa-arrow-right-long"></i></span>
            </button>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- SUPER PREMIUM BOTTOM SHEET POP-UP (GLASS) --}}
{{-- ========================================== --}}
<div id="checkout-modal" class="ed-modal-overlay">
    <div class="ed-bottom-sheet">
        <div class="ed-drag-line"></div>
        <button type="button" id="btn-close-modal" class="ed-close-btn"><i class="fa-solid fa-xmark"></i></button>

        <div class="ed-sheet-header">
            <img src="{{ $produk->gambar_utama ? $produk->gambar_utama : asset('images/kopi-arabica.png') }}" alt="Produk">
            <div class="ed-sheet-info">
                <h3>Rp {{ number_format($produk->harga, 0, ',', '.') }}</h3>
                <div class="ed-sheet-badges">
                    <span>Stok: {{ $produk->stok }}</span>
                    <span class="gold-badge">Reserve</span>
                </div>
            </div>
        </div>
        
        <form action="{{ route('keranjang.tambah') }}" method="POST">
            @csrf
            <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
            <input type="hidden" name="action" value="checkout">
            
            <div class="ed-qty-row">
                <div class="ed-qty-text">
                    <h4>Kuantitas</h4>
                    <p>Tentukan jumlah mahakarya</p>
                </div>
                <div class="ed-qty-controls">
                    <button type="button" id="qty-minus"><i class="fa-solid fa-minus"></i></button>
                    <input type="number" name="jumlah" id="qty-input" value="1" min="1" max="{{ $produk->stok > 0 ? $produk->stok : 1 }}" readonly>
                    <button type="button" id="qty-plus"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>

            <button type="submit" class="btn-ed-checkout" {{ $produk->stok < 1 ? 'disabled' : '' }}>
                <span>{{ $produk->stok < 1 ? 'Koleksi Habis' : 'Selesaikan Pembayaran' }}</span>
                @if($produk->stok > 0)
                    <span class="btn-dot">•</span>
                    <span id="dynamic-price-sheet">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                @endif
            </button>
        </form>
    </div>
</div>

{{-- TOAST NOTIFICATION --}}
<div id="ed-toast" class="ed-toast">
    <i class="fa-solid fa-check-circle"></i>
    <span id="ed-toast-msg">Notifikasi</span>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnCheckoutTrigger = document.getElementById('btn-trigger-checkout');
        const btnCloseModal = document.getElementById('btn-close-modal');
        const modal = document.getElementById('checkout-modal');
        
        const btnMinus = document.getElementById('qty-minus');
        const btnPlus = document.getElementById('qty-plus');
        const inputQty = document.getElementById('qty-input');
        const priceDisplay = document.getElementById('dynamic-price-sheet');
        
        const basePrice = {{ $produk->harga }};
        const maxStok = parseInt(inputQty.getAttribute('max')) || 1; 

        // Fungsi Memunculkan Toast
        function showToast(message) {
            const toast = document.getElementById('ed-toast');
            const toastMsg = document.getElementById('ed-toast-msg');
            if(toast && toastMsg) {
                toastMsg.textContent = message;
                toast.classList.add('show');
                setTimeout(() => { toast.classList.remove('show'); }, 3000);
            }
        }

        // FUNGSI UTAMA: Notifikasi Keranjang tanpa reload instan
        const btnAddCartDirect = document.getElementById('btn-add-cart-direct');
        if (btnAddCartDirect) {
            btnAddCartDirect.addEventListener('click', function(e) {
                e.preventDefault(); // Tahan dulu form-nya
                
                // Munculkan notifikasi elit
                showToast('Mahakarya ditambahkan ke keranjang.');
                
                // Ubah teks tombol jadi loading state
                this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
                this.style.backgroundColor = '#1A251C';
                this.style.color = '#F9F6F0';
                
                // Submit form ke Laravel setelah delay 1.5 detik
                const form = document.getElementById('form-direct-cart');
                setTimeout(() => { form.submit(); }, 1500);
            });
        }

        // Logika Pop-up Modal (Checkout)
        if (btnCheckoutTrigger) {
            btnCheckoutTrigger.addEventListener('click', () => { modal.classList.add('show'); });
        }
        function closeModal() { modal.classList.remove('show'); }
        if (btnCloseModal) btnCloseModal.addEventListener('click', closeModal);
        if (modal) {
            modal.addEventListener('click', (e) => { if(e.target === modal) closeModal(); });
        }

        // Format Rupiah
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka).replace('Rp', 'Rp ');
        }

        function updatePriceDisplay(qty) {
            if(!priceDisplay) return;
            priceDisplay.textContent = formatRupiah(basePrice * qty);
        }

        // Qty Controls
        if (btnMinus) {
            btnMinus.addEventListener('click', () => {
                let current = parseInt(inputQty.value);
                if(current > 1) {
                    current -= 1;
                    inputQty.value = current;
                    updatePriceDisplay(current);
                }
            });
        }
        if (btnPlus) {
            btnPlus.addEventListener('click', () => {
                let current = parseInt(inputQty.value);
                if(current < maxStok) {
                    current += 1;
                    inputQty.value = current;
                    updatePriceDisplay(current);
                } else {
                    showToast('Batas koleksi: ' + maxStok + ' pcs');
                }
            });
        }
    });
</script>


@endsection