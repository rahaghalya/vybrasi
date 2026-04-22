@extends('layouts.app')

@section('title', 'Vybrasi - Beranda')

@section('content')
<header class="hero">
    <div class="hero-card">
        <div class="hero-text">
            <h1>Racikan Kopi Premium dengan Sentuhan Gula Aren Asli Nusantara</h1>
            <p>Racikan terbaik dengan cita rasa autentik</p>
            <a href="#" class="btn-dark">
                <i class="fa-solid fa-table-cells"></i> Lihat Produk
            </a>
        </div>
        <div class="hero-image">
            <img src="{{ asset('images/foto_beranda.png') }}" alt="Kopi Premium">
        </div>
    </div>
</header>

    <section class="tentang">
        <div class="tentang-images">
            <div class="shape-blob"></div>
            <img src="{{ asset('images/cafe-1.jpg') }}" class="img-top" alt="Suasana Cafe 1">
            <img src="{{ asset('images/cafe-2.jpg') }}" class="img-bottom" alt="Suasana Cafe 2">
        </div>
        <div class="tentang-text">
            <h2>Tentang Kami</h2>
            <p>Kami menghadirkan specialty coffee berkualitas tinggi, dipilih secara selektif dari perkebunan terbaik dan diracik dengan presisi untuk menonjolkan kompleksitas serta keunikan karakter rasanya. Setiap cangkir disiapkan dengan standar tinggi, mengutamakan keseimbangan, konsistensi, dan detail dalam setiap prosesnya. Dengan dedikasi terhadap kualitas tanpa kompromi, kami menghadirkan pengalaman menikmati kopi yang elegan, berkelas, dan tak terlupakan.</p>
            <a href="{{ route('tentang') }}" class="btn-orange">Tentang</a>
        </div>
    </section>

    <section class="produk">
        <div class="section-header">
            <h2>Produk Kami</h2>
            <p>Diracik dengan kualitas terbaik untuk pengalaman di setiap tegukan.</p>
        </div>
        <div class="produk-grid">
            @for ($i = 0; $i < 6; $i++)
            <div class="produk-card">
                <div class="produk-img-placeholder">
                    @if($i == 0)
                        <img src="{{ asset('images/kopi-1.jpg') }}" alt="Kopi">
                    @endif
                </div>
                <div class="produk-info">
                    <h3>{{ $i == 0 ? 'Kopi' : 'Nama Produk' }}</h3>
                    <a href="{{ route('produk.detail') }}" class="btn-brown-sm">Lihat Produk</a>
                </div>
            </div>
            @endfor
        </div>
    </section>

    <section class="unggulan">
        <div class="section-header">
            <h2>Produk Unggulan Kami</h2>
            <p>Karya racikan terbaik kami, diproses dengan presisi untuk menghadirkan pengalaman kopi autentik yang kaya karakter dan berkelas.</p>
        </div>
        <div class="unggulan-grid">
            <div class="unggulan-card">
                <div class="unggulan-img-placeholder"></div>
                <div class="unggulan-info">
                    <h3>Biji Kopi</h3>
                    <p>dhfvehnsdbiugehbdubfchfbefsdvbcudbcfnedjhbcehcfhhebshcdhbefcjbfcbscudevbdhbeqdgfojb</p>
                    <a href="#" class="btn-brown">Lihat Menu</a>
                </div>
            </div>
            <div class="unggulan-card">
                <div class="unggulan-img-placeholder"></div>
                <div class="unggulan-info">
                    <h3>Gula Aren</h3>
                    <p>dhfvehnsdbiugehbdubfchfbefsdvbcudbcfnedjhbcehcfhhebshcdhbefcjbfcbscudevbdhbeqdgfojb</p>
                    <a href="#" class="btn-brown">Lihat Menu</a>
                </div>
            </div>
            <div class="unggulan-card">
                <div class="unggulan-img-placeholder"></div>
                <div class="unggulan-info">
                    <h3>Nama Produk</h3>
                    <p>dhfvehnsdbiugehbdubfchfbefsdvbcudbcfnedjhbcehcfhhebshcdhbefcjbfcbscudevbdhbeqdgfojb</p>
                    <a href="#" class="btn-brown">Lihat Menu</a>
                </div>
            </div>
        </div>
    </section>
@endsection