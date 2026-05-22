@extends('layouts.app')

@section('title', 'Vybrasi - Tentang Kami')

@section('content')
<div class="vy-hybrid-wrapper">
    
    {{-- 1. HERO SECTION: CLASSIC FULL WIDTH --}}
    <section class="std-hero" style="background-image: url('{{ !empty($cms["tentang_image"]) ? asset($cms["tentang_image"]) : asset("images/gambar_tentang.png") }}');">
        <div class="std-overlay"></div>
        <div class="std-hero-content fade-in-up">
            <h1>Kisah & Dedikasi</h1>
            <div class="std-divider"></div>
            <p>Mengenal lebih dekat perjalanan kami dalam menghadirkan kopi berkualitas, diracik dengan kecintaan terhadap setiap detail rasa.</p>
        </div>
    </section>

    {{-- 2. MISI KAMI: GALLERY PLAQUE WIREFRAME --}}
    <section class="premium-mission-wireframe">
        <div class="mission-header-center fade-in-up">
            <h2>Pilar Vybrasi.</h2>
            <span class="subtitle-italic">Fondasi dari setiap cangkir yang disajikan.</span>
        </div>
        
        <div class="mission-wireframe-grid">
            
            <div class="wireframe-cell stagger-anim" style="animation-delay: 0.2s;">
                <div class="cell-top">
                    <span class="cell-number">01</span>
                    <i class="fa-solid fa-leaf cell-icon"></i>
                </div>
                <div class="cell-body">
                    <h3>Kualitas Premium</h3>
                    <p>Kualitas terbaik yang dirancang khusus untuk menciptakan pengalaman rasa yang istimewa di lidah Anda.</p>
                </div>
            </div>
            
            <div class="wireframe-cell stagger-anim" style="animation-delay: 0.35s;">
                <div class="cell-top">
                    <span class="cell-number">02</span>
                    <i class="fa-solid fa-seedling cell-icon"></i>
                </div>
                <div class="cell-body">
                    <h3>Seleksi Terbaik</h3>
                    <p>Biji kopi pilihan yang dikurasi langsung dari sumber terpercaya dan petani lokal nusantara.</p>
                </div>
            </div>
            
            <div class="wireframe-cell stagger-anim" style="animation-delay: 0.5s;">
                <div class="cell-top">
                    <span class="cell-number">03</span>
                    <i class="fa-solid fa-mug-hot cell-icon"></i>
                </div>
                <div class="cell-body">
                    <h3>Dedikasi Rasa</h3>
                    <p>Diracik dengan presisi tingkat tinggi dan perhatian penuh pada setiap detail proses penyeduhan.</p>
                </div>
            </div>
            
        </div>
    </section>

    {{-- 3. CERITA KAMI: DYNAMIC DIAGONAL FLOW --}}
    <section class="vy-dynamic-story">
        <div class="giant-watermark">VYBRASI</div>
        
        <div class="dynamic-story-container">
            
            {{-- Blok Cerita 1 --}}
            <div class="story-node node-left fade-in-up">
                <div class="node-meta">
                    <div class="meta-line"></div>
                </div>
                <h3>{{ $cms['tentang_card_1_title'] ?? 'Awal Mula Cerita Kami' }}</h3>
                <p class="drop-cap-dynamic">
                    {{ $cms['tentang_cerita_1'] ?? 'Berawal dari kecintaan terhadap specialty coffee, kami menghadirkan biji pilihan dan proses terbaik untuk menciptakan pengalaman kopi yang autentik, konsisten, dan berkelas di setiap sajian.' }}
                </p>
            </div>
            
            {{-- Blok Cerita 2 --}}
            <div class="story-node node-right fade-in-up" style="animation-delay: 0.3s;">
                <div class="glass-card">
                    <div class="node-meta">
                        <div class="meta-line"></div>
                    </div>
                    <h3>{{ $cms['tentang_card_2_title'] ?? 'Lebih Dari Sekadar Minuman' }}</h3>
                    <p>
                        {{ $cms['tentang_cerita_2'] ?? 'Kami percaya kopi bukan sekadar minuman, melainkan pengalaman. Melalui seleksi biji terbaik dan proses yang presisi, kami menghadirkan kualitas dan cita rasa yang dapat dinikmati oleh setiap penikmat kopi sejati.' }}
                    </p>
                </div>
            </div>
            
        </div>
    </section>

</div>
@endsection