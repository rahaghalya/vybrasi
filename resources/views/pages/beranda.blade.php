@extends('layouts.app')

@section('title', 'Vybrasi - Beranda')

@section('content')
<header class="hero">
        <div class="hero-container">
            {{-- Gambar Pemadangan (Lebih lebar dan megah) --}}
            <div class="hero-image">
                <img src="{{ isset($cms['hero_image']) ? asset($cms['hero_image']) : asset('images/foto_beranda.png') }}" alt="Pemandangan Kebun Kopi">
            </div>
            
            {{-- Kotak Teks dengan Efek Frosted Glass (Kaca Buram) --}}
            <div class="hero-text-card">
                {{-- Badge Mikro Ala Butik Premium --}}
                <div class="premium-badge">100% ORGANIC SPECIALTY COFFEE</div>
                
                <h1>{{ $cms['hero_title'] ?? 'Racikan Kopi Premium dengan Gula Aren Asli' }}</h1>
                
                {{-- Garis Pemisah Elegan --}}
                <div class="separator-line"></div>
                
                <p>{{ $cms['hero_subtitle'] ?? 'Cita rasa autentik nusantara dalam setiap seduhan.' }}</p>
                
                {{-- Tombol Minimalis Mewah --}}
                <a href="{{ route('produk') }}" class="btn-ultra-premium">
                    <span>Kepoin Produk Kami</span>
                    <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>
        </div>
    </header>

    <section class="tentang">
        <div class="tentang-images">
            {{-- Bingkai Estetik di Belakang Foto --}}
            <div class="image-frame-outline"></div>
            <div class="shape-blob"></div>
            
            {{-- Foto Utama (Besar) --}}
            <img src="{{ isset($cms['beranda_cafe_1']) ? asset($cms['beranda_cafe_1']) : asset('images/cafe-1.jpg') }}" class="img-main" alt="Suasana Cafe 1">
            
            {{-- Foto Melayang (Kecil di depan) --}}
            <img src="{{ isset($cms['beranda_cafe_2']) ? asset($cms['beranda_cafe_2']) : asset('images/cafe-2.jpg') }}" class="img-float" alt="Suasana Cafe 2">
        </div>
        
        <div class="tentang-text">
            {{-- Badge Premium --}}
            <div class="premium-badge-dark">KISAH KAMI</div>
            
            <h2>Tentang Kami</h2>
            
            {{-- Garis Pemisah --}}
            <div class="separator-line-dark"></div>
            
            <p>Kami menghadirkan specialty coffee berkualitas tinggi, dipilih secara selektif dari perkebunan terbaik dan diracik dengan presisi untuk menonjolkan kompleksitas serta keunikan karakter rasanya.</p>
            
            {{-- Tombol Outline Premium --}}
            <a href="{{ route('tentang') }}" class="btn-outline-premium">
                <span>Baca Selengkapnya</span>
                <i class="fa-solid fa-arrow-right-long"></i>
            </a>
        </div>
    </section>


 {{-- SECTION TESTIMONI (AWWWARDS WINNING - GLASS & MARQUEE) --}}
    <section class="awwwards-testi-section">
        
        {{-- Background Teks Berjalan (Infinite Marquee) --}}
        <div class="marquee-bg-container">
            <div class="marquee-track">
                <span>VYBRASI SIGNATURE • SUARA PELANGGAN • </span>
                <span>VYBRASI SIGNATURE • SUARA PELANGGAN • </span>
                <span>VYBRASI SIGNATURE • SUARA PELANGGAN • </span>
                <span>VYBRASI SIGNATURE • SUARA PELANGGAN • </span>
            </div>
        </div>

        <div class="awwwards-testi-content">
            <div class="awwwards-header">
                <span class="awwwards-badge">Kisah Mereka</span>
                <h2>Jejak Rasa Vybrasi</h2>
            </div>
            
            <div class="awwwards-grid">
                @forelse ($testimonials as $testi)
                    <div class="awwwards-glass-card">
                        <div class="awwwards-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" style="color: {{ $i <= $testi->rating ? '#C1A68D' : 'rgba(249, 246, 240, 0.1)' }};"></i>
                            @endfor
                        </div>
                        
                        <p class="awwwards-quote">"{{ $testi->komentar }}"</p>
                        
                        <div class="awwwards-author-wrapper">
                            <div class="author-line"></div>
                            <div class="author-details">
                                <h4>{{ $testi->nama ?? $testi->nama_pelanggan ?? 'Pelanggan Setia' }}</h4>
                                
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="awwwards-empty">
                        <p>Belum ada jejak rasa yang tertinggal saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection