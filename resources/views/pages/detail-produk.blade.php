@extends('layouts.app')

@section('title', 'Vybrasi - Detail Produk')

@section('content')
<div class="page-detail-container">
    <div class="detail-card">
        
        <div class="detail-top-row">
            <div class="detail-info">
                <h1 class="premium-serif">Kopi Arabica 250gr</h1>
                <hr class="premium-divider">
                <p class="desc">Biji kopi Arabica berkualitas dalam kemasan 250gr, dipilih dari sumber terbaik untuk menghasilkan cita rasa kompleks, aroma harum, dan pengalaman seduh yang berkelas.</p>
                
                <div class="rating-summary-container">
                    <div class="rating-box-premium">
                        <span class="score">4.9</span>
                        <div class="stars-gold">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="total-review">128 ulasan</span>
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
                <div class="main-img-wrapper">
                    <img src="{{ asset('images/arabica-detail.png') }}" alt="Kopi Arabica 250gr" class="detail-img">
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

        <div class="premium-review-card">
            <div class="review-quote-icon">
                <i class="fa-solid fa-quote-left"></i>
            </div>
            <div class="review-header">
                <div class="reviewer-info">
                    <div class="avatar-circle">F</div>
                    <div class="reviewer-text">
                        <h4>Fadil Prasetyo</h4>
                        <p>14 Februari 2026 • Pembeli Terverifikasi</p>
                    </div>
                </div>
                <div class="review-stars-gold">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
            </div>
            <div class="review-content">
                <h5 class="premium-serif">"Aroma & rasa yang bikin nagih!"</h5>
                <p>Udah nyobain banyak brand kopi lokal, tapi Arabica VYBRASI beda level. Aromanya wangi banget pas diseduh V60, ada hint bunga jasmine yang khas. Body-nya cukup solid untuk diminum tanpa susu. Highly recommended!</p>
                <div class="review-pills">
                    <span class="pill">Smooth</span>
                    <span class="pill">Fresh</span>
                </div>
            </div>
        </div>

        <div class="detail-actions">
            <a href="javascript:history.back()" class="btn-outline-dark">
                <i class="fa-solid fa-arrow-left-long"></i> Kembali
            </a>
            <a href="{{ route('checkout') }}" class="btn-solid-caramel">
                Beli Langsung Disini <i class="fa-solid fa-arrow-right-long"></i>
            </a>
        </div>

    </div>
</div>
@endsection