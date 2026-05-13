@extends('layouts.app')

@section('title', 'Vybrasi - Tentang Kami')

@section('content')
<div class="tentang-banner" style="background-image: url('{{ asset("images/gambar_tentang.png") }}');">
    <div class="tentang-banner-text">
        <h2>Mengenal lebih dekat perjalanan kami dalam menghadirkan kopi berkualitas, diracik dengan dedikasi dan kecintaan terhadap setiap detail rasa.</h2>
    </div>
</div>

<div class="tentang-page-wrapper">
    <section class="misi-section">
        <div class="section-title-icon">
            <i class="fa-solid fa-sun"></i>
            <h2>MISI KAMI</h2>
        </div>
        
        <div class="misi-grid">
            <div class="misi-card">
                <i class="fa-solid fa-leaf misi-icon"></i>
                <div class="misi-text">
                    <h3>Kualitas Premium</h3>
                    <p>Kualitas terbaik yang dirancang untuk pengalaman rasa istimewa.</p>
                </div>
            </div>
            <div class="misi-card">
                <i class="fa-solid fa-seedling misi-icon"></i>
                <div class="misi-text">
                    <h3>Seleksi Terbaik</h3>
                    <p>Biji kopi pilihan dari sumber terpercaya.</p>
                </div>
            </div>
        </div>
        <div class="misi-grid-center">
            <div class="misi-card">
                <i class="fa-solid fa-mug-hot misi-icon"></i>
                <div class="misi-text">
                    <h3>Dedikasi Rasa</h3>
                    <p>Diracik dengan perhatian pada setiap detail.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="tentang-detail-section">
        <div class="section-title-icon">
            <i class="fa-solid fa-hourglass-half"></i>
            <h2>TENTANG KAMI</h2>
        </div>

        <div class="tentang-cards-container">
            <div class="tentang-card">
                {{-- UPDATE: Judul dan Teks jadi dinamis --}}
                <h3>{{ $cms['tentang_card_1_title'] ?? 'Cerita Kami' }}</h3>
                <p>{{ $cms['tentang_cerita_1'] ?? 'Berawal dari kecintaan terhadap specialty coffee, kami menghadirkan biji pilihan dan proses terbaik untuk menciptakan pengalaman kopi yang autentik, konsisten, dan berkelas di setiap sajian.' }}</p>
            </div>
            <div class="tentang-card">
                {{-- UPDATE: Judul dan Teks jadi dinamis --}}
                <h3>{{ $cms['tentang_card_2_title'] ?? 'Cerita Kami' }}</h3>
                <p>{{ $cms['tentang_cerita_2'] ?? 'Kami percaya kopi bukan sekadar minuman, melainkan pengalaman. Melalui seleksi biji terbaik dan proses yang presisi, kami menghadirkan kualitas dan cita rasa yang dapat dinikmati oleh setiap penikmat kopi sejati.' }}</p>
            </div>
        </div>
    </section>
</div>
@endsection