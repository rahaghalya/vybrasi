@extends('layouts.app')

@section('title', 'Vybrasi - Tentang Kami')

@section('content')
<div class="editorial-about-wrapper">
    
    {{-- HERO SECTION: CINEMATIC PARALLAX --}}
    <section class="about-hero" style="background-image: url('{{ asset("images/gambar_tentang.png") }}');">
        <div class="hero-overlay-dark"></div>
        <div class="hero-content fade-in-up">
            <span class="badge-outline">Jejak Vybrasi</span>
            <h1>Kisah & Dedikasi.</h1>
            <div class="hero-line"></div>
            <p>Mengenal lebih dekat perjalanan kami dalam menghadirkan kopi berkualitas, diracik dengan kecintaan terhadap setiap detail rasa.</p>
        </div>
    </section>

    {{-- MISI KAMI: MINIMALIST ARCHITECTURAL GRID --}}
    <section class="about-mission">
        <div class="mission-header fade-in-up" style="animation-delay: 0.2s;">
            <h2>Misi Kami</h2>
            <span class="subtitle-italic">Fondasi dari setiap cangkir yang kami sajikan.</span>
        </div>
        
        <div class="mission-grid">
            <div class="mission-item">
                <div class="mission-number">01</div>
                <div class="mission-icon"><i class="fa-solid fa-leaf"></i></div>
                <div class="mission-text-box">
                    <h3>Kualitas Premium</h3>
                    <p>Kualitas terbaik yang dirancang khusus untuk menciptakan pengalaman rasa yang istimewa di lidah Anda.</p>
                </div>
            </div>
            
            <div class="mission-item">
                <div class="mission-number">02</div>
                <div class="mission-icon"><i class="fa-solid fa-seedling"></i></div>
                <div class="mission-text-box">
                    <h3>Seleksi Terbaik</h3>
                    <p>Biji kopi pilihan yang dikurasi langsung dari sumber terpercaya dan petani lokal nusantara.</p>
                </div>
            </div>
            
            <div class="mission-item">
                <div class="mission-number">03</div>
                <div class="mission-icon"><i class="fa-solid fa-mug-hot"></i></div>
                <div class="mission-text-box">
                    <h3>Dedikasi Rasa</h3>
                    <p>Diracik dengan presisi tingkat tinggi dan perhatian penuh pada setiap detail proses penyeduhan.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CERITA KAMI: MAGAZINE EDITORIAL LAYOUT --}}
    <section class="about-story">
        <div class="story-container">
            
            {{-- Kolom Cerita 1 --}}
            <div class="story-col">
                <div class="story-chapter-wrap">
                    <div class="chapter-line"></div>
                    <span class="story-chapter">Babak Pertama</span>
                </div>
                <h3>{{ $cms['tentang_card_1_title'] ?? 'Awal Mula Cerita Kami' }}</h3>
                <p class="drop-cap">
                    {{ $cms['tentang_cerita_1'] ?? 'Berawal dari kecintaan terhadap specialty coffee, kami menghadirkan biji pilihan dan proses terbaik untuk menciptakan pengalaman kopi yang autentik, konsisten, dan berkelas di setiap sajian.' }}
                </p>
            </div>
            
            {{-- Kolom Cerita 2 --}}
            <div class="story-col">
                <div class="story-chapter-wrap">
                    <div class="chapter-line"></div>
                    <span class="story-chapter">Filosofi Rasa</span>
                </div>
                <h3>{{ $cms['tentang_card_2_title'] ?? 'Lebih Dari Sekadar Minuman' }}</h3>
                <p>
                    {{ $cms['tentang_cerita_2'] ?? 'Kami percaya kopi bukan sekadar minuman, melainkan pengalaman. Melalui seleksi biji terbaik dan proses yang presisi, kami menghadirkan kualitas dan cita rasa yang dapat dinikmati oleh setiap penikmat kopi sejati.' }}
                </p>
            </div>
            
        </div>
    </section>
</div>
@endsection