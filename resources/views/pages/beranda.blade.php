@extends('layouts.app')

@section('title', 'Vybrasi - Beranda')

@section('content')
    <header class="hero">
        <div class="hero-card">
            <div class="hero-text">
                {{-- UPDATE: Judul dan Subtitle sekarang dinamis memanggil dari CMS --}}
                <h1>{{ $cms['hero_title'] ?? 'Racikan Kopi Premium dengan Sentuhan Gula Aren Asli Nusantara' }}</h1>
                <p>{{ $cms['hero_subtitle'] ?? 'Racikan terbaik dengan cita rasa autentik' }}</p>
                
                <a href="{{ route('produk') }}" class="btn-ultra-premium" style="text-decoration: none;">
                    <i class="fa-solid fa-table-cells" style="color: #D4A373; z-index: 2;"></i> 
                    <span>Lihat Produk Kami</span>
                </a>
            </div>
            <div class="hero-image">
                {{-- UPDATE: Gambar Hero sekarang dinamis memanggil dari CMS --}}
                <img src="{{ isset($cms['hero_image']) ? asset($cms['hero_image']) : asset('images/foto_beranda.png') }}" alt="Kopi Premium">
            </div>
        </div>
    </header>

    <section class="tentang">
        <div class="tentang-images">
            <div class="shape-blob"></div>
            {{-- UPDATE: Diubah menjadi dinamis terhubung ke CMS --}}
            <img src="{{ isset($cms['beranda_cafe_1']) ? asset($cms['beranda_cafe_1']) : asset('images/cafe-1.jpg') }}" class="img-top" alt="Suasana Cafe 1">
            <img src="{{ isset($cms['beranda_cafe_2']) ? asset($cms['beranda_cafe_2']) : asset('images/cafe-2.jpg') }}" class="img-bottom" alt="Suasana Cafe 2">
        </div>
        <div class="tentang-text">
            <h2>Tentang Kami</h2>
            <p>Kami menghadirkan specialty coffee berkualitas tinggi, dipilih secara selektif dari perkebunan terbaik dan diracik dengan presisi untuk menonjolkan kompleksitas serta keunikan karakter rasanya.</p>
            <a href="{{ route('tentang') }}" class="btn-orange">Tentang</a>
        </div>
    </section>

    {{-- SECTION PRODUK KAMI DIHAPUS --}}

    {{-- SECTION UNGGULAN (SEKARANG MENJADI PRODUK UTAMA) --}}
    <section class="unggulan">
        <div class="section-header">
            <h2>Produk Unggulan Kami</h2>
            <p>Karya racikan terbaik kami, diproses dengan presisi untuk menghadirkan pengalaman kopi autentik.</p>
        </div>
        
        {{-- Style Inline untuk memastikan Grid 4 Kolom --}}
        <div class="unggulan-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
            @forelse ($featuredProducts as $item)
                <div class="unggulan-card">
                    <div class="unggulan-img-placeholder">
                        <img src="{{ $item->gambar_utama ? $item->gambar_utama : 'https://placehold.co/400x300/5a3c2a/FFF?text=' . urlencode($item->nama) }}" 
                             alt="{{ $item->nama }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="unggulan-info">
                        <h3>{{ $item->nama }}</h3>
                        <a href="{{ route('produk.detail', ['slug' => $item->slug]) }}" class="btn-brown">Lihat Menu</a>
                    </div>
                </div>
            @empty
                <div style="grid-column: span 4; text-align: center; color: #999; padding: 40px;">
                    <p>Belum ada produk unggulan yang tersedia.</p>
                </div>
            @endforelse
        </div>

        {{-- TOMBOL LIHAT SEMUA PRODUK (TAMBAHAN BARU) --}}
        <div style="text-align: center; margin-top: 50px;">
            <a href="{{ route('produk') }}" 
               style="display: inline-block; padding: 12px 30px; border: 2px solid #D4A373; color: #D4A373; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 16px; transition: all 0.3s ease;" 
               onmouseover="this.style.backgroundColor='#D4A373'; this.style.color='#111';" 
               onmouseout="this.style.backgroundColor='transparent'; this.style.color='#D4A373';">
                Lihat Semua Produk <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
            </a>
        </div>
    </section>

    {{-- TESTIMONI --}}
    <section class="testimonial-section">
        <div class="section-header">
            <h2>Pengalaman Bersama Kami</h2>
            <p>Cerita nyata dari mereka yang telah mencicipi seduhan Vybrasi.</p>
        </div>
        <div class="testi-grid">
            @forelse ($testimonials as $testi)
                <div class="testi-card">
                    <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
                    <div class="testi-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star" style="color: {{ $i <= $testi->rating ? '#FFD700' : '#e0e0e0' }};"></i>
                        @endfor
                    </div>
                    <p class="testi-text">"{{ $testi->komentar }}"</p>
                    <div class="testi-separator"></div>
                    <div class="testi-author">{{ $testi->nama ?? $testi->nama_pelanggan ?? 'Pelanggan Setia' }}</div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: #999; padding: 20px;">
                    <p>Belum ada ulasan saat ini.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection