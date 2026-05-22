@extends('layouts.app')

@section('title', 'Vybrasi - Detail Produk')

@section('content')
<div class="page-detail-container">
    <div class="detail-card">
        
        <div class="detail-top-row">
            <div class="detail-info">
                <h1 class="premium-serif">{{ $produk->nama }}</h1>
                
                <h2 style="color: #D4A373; margin: 10px 0; font-size: 28px; font-weight: 800; letter-spacing: -0.5px;">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </h2>

                <hr class="premium-divider">
                
                <p class="desc">
                    {{ $produk->deskripsi_singkat ?? $produk->deskripsi_lengkap ?? 'Biji kopi pilihan terbaik, diproses dengan cermat untuk menghasilkan cita rasa kompleks, aroma harum, dan pengalaman seduh yang berkelas.' }}
                </p>
                
                <div class="rating-summary-container">
                    <div class="rating-box-premium">
                        <span class="score">{{ $produk->ulasan->count() > 0 ? number_format($produk->ulasan->avg('rating'), 1) : '0.0' }}</span>
                        <div class="stars-gold">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="total-review">{{ $produk->ulasan->count() }} ulasan</span>
                    </div>
                    
                    <div class="rating-bars-premium">
                        @foreach([5 => 85, 4 => 35, 3 => 10, 2 => 5, 1 => 0] as $star => $width)
                        <div class="bar-row">
                            <span class="star-label">{{ $star }} <i class="fa-solid fa-star"></i></span>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ $width }}%;"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="detail-image-section">
                <div class="main-img-wrapper" style="box-shadow: 0 15px 30px rgba(0,0,0,0.08); border-radius: 16px; overflow: hidden;">
                    <img src="{{ $produk->gambar_utama ? $produk->gambar_utama : 'https://placehold.co/400x350/5a3c2a/FFF?text=' . urlencode($produk->nama) }}" 
                         alt="{{ $produk->nama }}" 
                         class="detail-img" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                </div>
                <div class="feature-stamps">
                    <div class="stamp-item">
                        <i class="fa-solid fa-leaf"></i>
                        <span>100%<br>Alami</span>
                    </div>
                    <div class="stamp-item">
                        <i class="fa-solid fa-award"></i>
                        <span>Quality<br>First</span>
                    </div>
                    <div class="stamp-item">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <span>Single<br>Origin</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN ULASAN DINAMIS --}}
        <div class="ulasan-container" style="margin-top: 40px;">
            <h3 style="margin-bottom: 25px; color: #2c2c2c; font-size: 22px; border-left: 4px solid #D4A373; padding-left: 10px;">Ulasan Pembeli ({{ $produk->ulasan->count() }})</h3>
            
            @forelse ($produk->ulasan as $ulasan)
                <div class="premium-review-card" style="margin-bottom: 20px;">
                    <div class="review-quote-icon">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>
                    <div class="review-header">
                        <div class="reviewer-info">
                            <div class="avatar-circle">{{ substr($ulasan->user->full_name ?? 'A', 0, 1) }}</div>
                            <div class="reviewer-text">
                                <h4>{{ $ulasan->user->full_name ?? 'Pengguna Anonim' }}</h4>
                                <p>
                                    {{ \Carbon\Carbon::parse($ulasan->created_at)->translatedFormat('d F Y') }} 
                                    @if($ulasan->is_verified_purchase)
                                        • <span style="color: #28a745;"><i class="fa-solid fa-circle-check"></i> Pembeli Terverifikasi</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="review-stars-gold">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star" style="color: {{ $i <= $ulasan->rating ? '#FFD700' : '#e0e0e0' }};"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="review-content">
                        <h5 class="premium-serif">"{{ $ulasan->judul ?? 'Ulasan Produk' }}"</h5>
                        <p>{{ $ulasan->komentar }}</p>
                        
                        @if(!empty($ulasan->gambar))
                            <div class="review-images" style="display: flex; gap: 10px; margin-top: 15px;">
                                @foreach($ulasan->gambar as $img)
                                    <img src="{{ asset('storage/'.$img) }}" alt="Foto Ulasan" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-review" style="text-align: center; padding: 50px 20px; background: #faf8f5; border-radius: 16px; border: 1px dashed #eaddcf;">
                    <div style="width: 80px; height: 80px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                        <i class="fa-regular fa-comments" style="font-size: 35px; color: #D4A373;"></i>
                    </div>
                    <h4 style="color: #333; margin-bottom: 5px;">Belum Ada Ulasan</h4>
                    <p style="color: #888; font-size: 14px;">Jadilah yang pertama menikmati dan memberikan ulasan untuk produk ini!</p>
                </div>
            @endforelse
        </div>

        {{-- AREA TOMBOL AKSI BAWAH --}}
        <div class="detail-actions" style="margin-top: 40px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; padding-top: 25px; border-top: 1px solid #f0f0f0;">
            <a href="{{ route('produk') }}" class="btn-outline-dark" style="display: flex; align-items: center; justify-content: center; text-decoration: none; padding: 14px 28px; border-radius: 12px; transition: all 0.3s;">
                <i class="fa-solid fa-arrow-left-long" style="margin-right: 8px;"></i> Kembali
            </a>
            
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <form action="{{ route('keranjang.tambah') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                    <input type="hidden" name="jumlah" value="1">
                    <button type="submit" name="action" value="keranjang" class="btn-action-cart">
                        <i class="fa-solid fa-cart-plus" style="margin-right: 8px;"></i> Masukkan Keranjang 
                    </button>
                </form>

                <button type="button" id="btn-trigger-tiktok" class="btn-action-buy">
                    Beli Sekarang <i class="fa-solid fa-bolt" style="margin-left: 8px;"></i>
                </button>
            </div>
        </div>

    </div>
</div>

{{-- ========================================== --}}
{{-- SUPER PREMIUM BOTTOM SHEET POP-UP --}}
{{-- ========================================== --}}
<div id="tiktok-modal" class="tiktok-overlay">
    <div class="tiktok-bottom-sheet">
        {{-- Garis Tarik Penanda --}}
        <div class="drag-indicator"></div>
        
        <button type="button" id="btn-close-tiktok" class="tiktok-close"><i class="fa-solid fa-xmark"></i></button>

        <div class="tiktok-header">
            <div class="tiktok-img-box">
                <img src="{{ $produk->gambar_utama ? $produk->gambar_utama : asset('images/kopi-arabica.png') }}" alt="Foto Produk">
            </div>
            <div class="tiktok-info">
                {{-- Harga Satuan --}}
                <h3 class="tiktok-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h3>
                <div class="tiktok-badges">
                    <span class="premium-badge-stock"><i class="fa-solid fa-box-open"></i> Sisa Stok: {{ $produk->stok }}</span>
                    <span class="premium-badge-variant"><i class="fa-solid fa-medal"></i> Premium</span>
                </div>
            </div>
        </div>
        
        <form action="{{ route('keranjang.tambah') }}" method="POST" class="tiktok-form">
            @csrf
            <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
            <input type="hidden" name="action" value="checkout">
            
            <div class="tiktok-qty-section">
                <div class="qty-label-box">
                    <span class="qty-title">Jumlah Pembelian</span>
                    <span class="qty-subtitle">Atur sesuai keinginanmu</span>
                </div>
                
                {{-- Kontrol QTY Desain Pill Baru --}}
                <div class="premium-qty-controls">
                    <button type="button" id="tt-minus"><i class="fa-solid fa-minus"></i></button>
                    <input type="number" name="jumlah" id="tt-qty" value="1" min="1" max="{{ $produk->stok > 0 ? $produk->stok : 1 }}" readonly>
                    <button type="button" id="tt-plus"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>

            {{-- Tombol Beli yang Super Cantik dengan Total Harga di dalamnya --}}
            <button type="submit" class="tiktok-submit-btn" id="btn-submit-checkout" {{ $produk->stok < 1 ? 'disabled' : '' }}>
                <span class="btn-text-action">{{ $produk->stok < 1 ? 'Stok Habis' : 'Lanjut Pembayaran' }}</span>
                @if($produk->stok > 0)
                    <span class="btn-separator">•</span>
                    <span class="btn-total-price" id="dynamic-total-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                @endif
            </button>
        </form>
    </div>
</div>

{{-- TOAST NOTIFICATION (PENGGANTI ALERT BAWAAN) --}}
<div id="custom-toast" class="custom-toast">
    <i class="fa-solid fa-circle-exclamation"></i>
    <span id="toast-message">Pesan notifikasi di sini.</span>
</div>

<style>
    /* Hover Effects Utama */
    .detail-img:hover { transform: scale(1.05); }
    
    .btn-action-cart {
        background: transparent; color: #D4A373; border: 2px solid #D4A373; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 14px 28px; border-radius: 14px; font-weight: bold; font-size: 16px; transition: all 0.3s ease;
    }
    .btn-action-cart:hover { background: #fdfaf6; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(212, 163, 115, 0.15); }
    
    .btn-action-buy {
        background: linear-gradient(135deg, #D4A373, #b58555); color: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 14px 28px; border-radius: 14px; font-weight: bold; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(212, 163, 115, 0.25);
    }
    .btn-action-buy:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(212, 163, 115, 0.4); filter: brightness(1.05); }

    /* --- CSS SUPER PREMIUM POP-UP --- */
    .tiktok-overlay {
        display: none; position: fixed; z-index: 9999; left: 0; top: 0;
        width: 100%; height: 100%; background: rgba(0, 0, 0, 0.55);
        align-items: flex-end; justify-content: center; backdrop-filter: blur(5px);
        opacity: 0; transition: opacity 0.3s ease;
    }
    .tiktok-overlay.show { display: flex; opacity: 1; }

    .tiktok-bottom-sheet {
        background: #ffffff; width: 100%; max-width: 550px;
        border-radius: 32px 32px 0 0; padding: 20px 30px 40px 30px;
        transform: translateY(100%); 
        transition: transform 0.45s cubic-bezier(0.2, 0.8, 0.2, 1.1); /* Spring effect cantik */
        box-shadow: 0 -15px 40px rgba(0,0,0,0.15);
        position: relative;
    }
    .tiktok-overlay.show .tiktok-bottom-sheet { transform: translateY(0); }

    .drag-indicator {
        width: 50px; height: 6px; background: #e0e0e0;
        border-radius: 10px; margin: 0 auto 25px auto;
    }

    .tiktok-close {
        position: absolute; top: 20px; right: 25px; width: 36px; height: 36px;
        background: #f8f9fa; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 16px; color: #555; cursor: pointer; transition: all 0.2s;
    }
    .tiktok-close:hover { background: #feebeb; color: #d9534f; transform: rotate(90deg); }

    .tiktok-header { display: flex; gap: 20px; border-bottom: 1px solid #f2f2f2; padding-bottom: 25px; margin-bottom: 25px; align-items: center; }
    
    .tiktok-img-box {
        width: 100px; height: 100px; border-radius: 18px; padding: 4px; border: 1px solid #f0f0f0; background: #fff; box-shadow: 0 8px 20px rgba(0,0,0,0.06); flex-shrink: 0;
    }
    .tiktok-img-box img { width: 100%; height: 100%; object-fit: cover; border-radius: 14px; }
    
    .tiktok-info { flex-grow: 1; display: flex; flex-direction: column; justify-content: center; }
    .tiktok-price { color: #D4A373; margin: 0 0 12px 0; font-size: 26px; font-weight: 800; letter-spacing: -0.5px; }
    
    .tiktok-badges { display: flex; gap: 8px; flex-wrap: wrap; }
    .premium-badge-stock { background: #fdfaf6; color: #D4A373; font-size: 13px; font-weight: 600; padding: 6px 12px; border-radius: 20px; border: 1px solid #f5ebd9; }
    .premium-badge-variant { background: #f8f9fa; color: #666; font-size: 13px; font-weight: 600; padding: 6px 12px; border-radius: 20px; border: 1px solid #eee; }

    .tiktok-qty-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
    .qty-label-box { display: flex; flex-direction: column; }
    .qty-title { font-weight: 700; color: #333; font-size: 16px; margin-bottom: 4px; }
    .qty-subtitle { font-size: 13px; color: #999; }
    
    .premium-qty-controls { 
        display: flex; align-items: center; background: #f8f9fa; border-radius: 50px; padding: 4px; border: 1px solid #eee;
    }
    .premium-qty-controls button {
        background: #fff; border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; color: #D4A373; font-size: 14px; transition: all 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; justify-content: center; align-items: center;
    }
    .premium-qty-controls button:hover { background: #D4A373; color: white; }
    .premium-qty-controls button:active { transform: scale(0.9); }
    .premium-qty-controls input {
        width: 45px; text-align: center; border: none; font-weight: 800; outline: none; background: transparent; font-size: 16px; color: #333;
    }

    .tiktok-submit-btn {
        width: 100%; display: flex; justify-content: center; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #D4A373, #c38c53); color: white; border: none; padding: 18px; border-radius: 16px; font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 10px 25px rgba(212, 163, 115, 0.35); position: relative; overflow: hidden;
    }
    .tiktok-submit-btn::after {
        content: ''; position: absolute; top: 0; left: -100%; width: 50%; height: 100%; background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%); transform: skewX(-20deg); transition: 0.5s;
    }
    .tiktok-submit-btn:hover::after { left: 150%; }
    .tiktok-submit-btn:hover:not(:disabled) { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(212, 163, 115, 0.45); }
    .tiktok-submit-btn:active:not(:disabled) { transform: translateY(0); }
    .tiktok-submit-btn:disabled { background: #e0e0e0; box-shadow: none; cursor: not-allowed; color: #999; }
    
    .btn-separator { opacity: 0.7; font-weight: 400; }
    .btn-total-price { font-size: 18px; font-weight: 800; }

    /* --- CSS TOAST NOTIFICATION --- */
    .custom-toast {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(-150%);
        background: #fff;
        color: #d9534f;
        padding: 12px 25px;
        border-radius: 30px;
        box-shadow: 0 10px 30px rgba(217, 83, 79, 0.2);
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 15px;
        font-weight: 600;
        z-index: 10000;
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        pointer-events: none;
        border: 1px solid #f9d6d5;
    }
    .custom-toast i {
        font-size: 18px;
    }
    .custom-toast.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }
</style>

{{-- SCRIPT ANIMASI & HARGA REAL-TIME --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnTrigger = document.getElementById('btn-trigger-tiktok');
        const btnClose = document.getElementById('btn-close-tiktok');
        const modal = document.getElementById('tiktok-modal');
        const bottomSheet = document.querySelector('.tiktok-bottom-sheet');
        
        const btnMinus = document.getElementById('tt-minus');
        const btnPlus = document.getElementById('tt-plus');
        const inputQty = document.getElementById('tt-qty');
        const priceDisplay = document.getElementById('dynamic-total-price');
        
        const basePrice = {{ $produk->harga }};
        const maxStok = parseInt(inputQty.getAttribute('max')) || 1; 

        // Fungsi memunculkan Toast Alert
        function showToast(message) {
            const toast = document.getElementById('custom-toast');
            const toastMsg = document.getElementById('toast-message');
            if(toast && toastMsg) {
                toastMsg.textContent = message;
                toast.classList.add('show');
                
                // Hilangkan otomatis setelah 3 detik
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { 
                style: 'currency', currency: 'IDR', minimumFractionDigits: 0 
            }).format(angka).replace('Rp', 'Rp ');
        }

        // Animasi harga di dalam tombol
        function updatePriceDisplay(qty) {
            if(!priceDisplay) return;
            const totalPrice = basePrice * qty;
            priceDisplay.textContent = formatRupiah(totalPrice);
            
            // Efek detak (pulse) yang halus
            priceDisplay.style.transform = 'scale(1.15)';
            priceDisplay.style.display = 'inline-block';
            priceDisplay.style.transition = 'transform 0.2s';
            setTimeout(() => {
                priceDisplay.style.transform = 'scale(1)';
            }, 200);
        }

        // Buka Pop-up
        if (btnTrigger) {
            btnTrigger.addEventListener('click', () => { 
                modal.classList.add('show'); 
            });
        }
        
        // Fungsi untuk menutup pop-up
        function closeModal() {
            bottomSheet.style.transform = 'translateY(100%)'; 
            setTimeout(() => {
                modal.classList.remove('show'); 
                bottomSheet.style.transform = ''; 
                inputQty.value = 1; 
                updatePriceDisplay(1);
            }, 300); 
        }

        if (btnClose) {
            btnClose.addEventListener('click', closeModal);
        }
        
        if (modal) {
            modal.addEventListener('click', (e) => { 
                if(e.target === modal) closeModal();
            });
        }

        // Logika Plus Minus
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
                    // PANGGIL TOAST DI SINI (BUKAN ALERT LAGI)
                    showToast('Batas maksimal pembelian: ' + maxStok + ' pcs');
                }
            });
        }
    });
</script>
@endsection