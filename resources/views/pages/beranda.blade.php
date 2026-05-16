@extends('layouts.app')

@section('title', 'Vybrasi - Beranda')

@section('content')

    {{-- HERO SECTION --}}
    <header class="hero">
        <div class="hero-card">
            <div class="hero-text">
                <h1>{{ $cms['hero_title'] ?? 'Racikan Kopi Premium dengan Gula Aren Asli' }}</h1>
                <p>{{ $cms['hero_subtitle'] ?? 'Cita rasa autentik nusantara dalam setiap seduhan.' }}</p>
                
                <a href="{{ route('produk') }}" class="btn-ultra-premium">
                    <span>Eksplor Menu Kami</span>
                    <i class="fa-solid fa-arrow-right-long"></i> 
                </a>
            </div>
            
            <div class="hero-image">
                <img src="{{ isset($cms['hero_image']) ? asset($cms['hero_image']) : asset('images/foto_beranda.png') }}" alt="Kopi Premium">
            </div>
        </div>
    </header>

    {{-- TENTANG SECTION --}}
    <section class="tentang">
        <div class="tentang-images">
            <div class="shape-blob"></div>
            <img src="{{ isset($cms['beranda_cafe_1']) ? asset($cms['beranda_cafe_1']) : asset('images/cafe-1.jpg') }}" class="img-top" alt="Suasana Cafe 1">
            <img src="{{ isset($cms['beranda_cafe_2']) ? asset($cms['beranda_cafe_2']) : asset('images/cafe-2.jpg') }}" class="img-bottom" alt="Suasana Cafe 2">
        </div>
        <div class="tentang-text">
            <h2>Tentang Kami</h2>
            <p>Kami menghadirkan specialty coffee berkualitas tinggi, dipilih secara selektif dari perkebunan terbaik dan diracik dengan presisi untuk menonjolkan keunikan karakter rasanya.</p>
            <a href="{{ route('tentang') }}" class="btn-orange">Selengkapnya</a>
        </div>
    </section>

    {{-- PRODUK UNGGULAN SECTION --}}
    <section class="unggulan">
        <div class="section-header">
            <h2>Produk Unggulan</h2>
            <p>Rekomendasi terbaik bagi para penikmat kopi sejati.</p>
        </div>
        
        <div class="unggulan-grid">
            @forelse ($featuredProducts as $item)
                <div class="unggulan-card">
                    <div class="unggulan-img-placeholder">
                        <img src="{{ $item->gambar_utama ? $item->gambar_utama : 'https://placehold.co/400x600/1B1616/D4A373?text=Kopi' }}" 
                             alt="{{ $item->nama }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="unggulan-info">
                        <h3>{{ $item->nama }}</h3>
                        <a href="{{ route('produk.detail', ['slug' => $item->slug]) }}" class="btn-brown">Detail Produk</a>
                    </div>
                </div>
            @empty
                <div style="grid-column: span 4; text-align: center; color: #666; padding: 40px;">
                    <p>Produk belum tersedia.</p>
                </div>
            @endforelse 
        </div>
    </section>

    {{-- TESTIMONI SECTION --}}
    <section class="testimonial-section">
        <div class="section-header">
            <h2>Ulasan Pelanggan</h2>
            <p>Apa kata mereka tentang pengalaman di Vybrasi?</p>
        </div>
        <div class="testi-grid">
            @forelse ($testimonials as $testi)
                <div class="testi-card">
                    <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
                    <div class="testi-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star" style="color: {{ $i <= $testi->rating ? '#D4A373' : '#333' }};"></i>
                        @endfor
                    </div>
                    <p class="testi-text">"{{ $testi->komentar }}"</p>
                    <div class="testi-separator"></div>
                    <div class="testi-author">{{ $testi->nama_pelanggan ?? 'Pelanggan Vybrasi' }}</div>
                </div>
            @empty
                <p style="text-align: center; color: #555; grid-column: 1 / -1;">Belum ada ulasan.</p>
            @endforelse
        </div>
    </section>

@endsection