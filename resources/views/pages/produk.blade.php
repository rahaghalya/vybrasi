@extends('layouts.app')

@section('title', 'Vybrasi - Koleksi Eksklusif')

@section('content')
<form action="{{ route('produk') }}" method="GET" id="filter-form">
    
    {{-- HERO TYPOGRAPHY (ANIMATED) --}}
    <section class="gallery-hero">
        <div class="gallery-hero-content fade-in-up">
            <span class="gallery-label-sm">Koleksi Terkurasi</span>
            <h1 class="gallery-title">Katalog <i>Vybrasi</i>.</h1>
            <div class="hero-thin-line"></div>
            <p class="gallery-subtitle">Eksplorasi mahakarya biji kopi pilihan, disangrai dengan presisi untuk menghadirkan kompleksitas rasa yang tak terlupakan.</p>
        </div>
    </section>

    {{-- SWIPEABLE FILTER INDEX (MOBILE OPTIMIZED) --}}
    <div class="gallery-filter-wrap">
        <div class="gallery-filter-inner">
            
            {{-- Wrapper agar bisa di-swipe di HP --}}
            <div class="gallery-swipe-container">
                <div class="gallery-links">
                    <label class="gallery-tab">
                        <input type="radio" name="kategori" value="" onchange="this.form.submit()" {{ empty(request('kategori')) ? 'checked' : '' }}>
                        <span class="g-tab-text">Semua</span>
                    </label>
                    <label class="gallery-tab">
                        <input type="radio" name="kategori" value="gula_aren" onchange="this.form.submit()" {{ request('kategori') == 'gula_aren' ? 'checked' : '' }}>
                        <span class="g-tab-text">Gula Aren</span>
                    </label>
                    <label class="gallery-tab">
                        <input type="radio" name="kategori" value="signature" onchange="this.form.submit()" {{ request('kategori') == 'signature' ? 'checked' : '' }}>
                        <span class="g-tab-text">Signature</span>
                    </label>
                    <label class="gallery-tab">
                        <input type="radio" name="kategori" value="unggulan" onchange="this.form.submit()" {{ request('kategori') == 'unggulan' ? 'checked' : '' }}>
                        <span class="g-tab-text">Unggulan</span>
                    </label>
                </div>
            </div>
            
            <div class="gallery-search">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari karya..." onkeypress="if(event.key === 'Enter') this.form.submit();">
                <i class="fa-solid fa-magnifying-glass" onclick="document.getElementById('filter-form').submit();"></i>
            </div>
        </div>
    </div>

    {{-- PRODUCT GALLERY GRID --}}
    <main class="gallery-main">
        <div class="gallery-grid">
            @forelse ($produks as $index => $item)
            <div class="g-card stagger-anim" style="animation-delay: {{ $index * 0.1 }}s;">
                <div class="g-image-wrap">
                    {{-- 1. FUNGSI KLIK GAMBAR DIHAPUS (Hanya tampilkan img biasa) --}}
                    <img src="{{ $item->gambar_utama ? $item->gambar_utama : 'https://placehold.co/600x800/1A251C/F9F6F0?text=' . urlencode($item->nama) }}" alt="{{ $item->nama }}">
                    
                    {{-- 2. TOMBOL ACTION DIUBAH MENJADI LINK KE DETAIL --}}
                    <div class="g-action-hover">
                        <a href="{{ route('produk.detail', ['slug' => $item->slug ?? 'default']) }}" class="btn-g-add" style="text-decoration: none;">
                            <span>Lihat Detail</span>
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </a>
                    </div>
                </div>
                
                <div class="g-info">
                    <div class="g-info-header">
                        <span class="g-meta">Single Origin</span>
                        <span class="g-price">IDR {{ number_format($item->harga, 0, ',', '.') }}</span>
                    </div>
                    <h3 class="g-product-name">
                        {{-- 3. FUNGSI KLIK JUDUL DIHAPUS --}}
                        {{ $item->nama }}
                    </h3>
                </div>
            </div>
            @empty
            <div class="g-empty">
                <p>Koleksi saat ini belum tersedia.</p>
            </div>
            @endforelse
        </div>

        {{-- TYPOGRAPHIC PAGINATION --}}
        @if ($produks->hasPages())
        <div class="g-pagination fade-in-up" style="animation-delay: 0.5s;">
            @if ($produks->onFirstPage())
                <span class="g-page-text disabled">Prev</span>
            @else
                <a href="{{ $produks->previousPageUrl() }}" class="g-page-text">Prev</a>
            @endif

            <div class="g-page-numbers">
                @foreach ($produks->getUrlRange(1, $produks->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="g-page-num {{ $page == $produks->currentPage() ? 'active' : '' }}">
                        @if($page < 10) 0{{ $page }} @else {{ $page }} @endif
                    </a>
                @endforeach
            </div>

            @if ($produks->hasMorePages())
                <a href="{{ $produks->nextPageUrl() }}" class="g-page-text">Next</a>
            @else
                <span class="g-page-text disabled">Next</span>
            @endif
        </div>
        @endif
    </main>
</form>

{{-- CATATAN: Kodingan hidden form keranjang di bawah sini sudah SAYA HAPUS karena
     sekarang fitur "Add to Cart" hanya bisa dilakukan di dalam Halaman Detail Produk. 
     Ini membuat source code kamu jadi jauh lebih ringan dan bersih! --}}

@endsection