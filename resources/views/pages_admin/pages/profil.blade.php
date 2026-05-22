@extends('layouts.app')

@section('title', 'Vybrasi - Menu Profil')

@section('content')
<div class="vy-luxury-profile-wrapper">
    <div class="editorial-profile-container fade-in-up">
        
        <div class="profile-split-layout">
            
            {{-- KOLOM KIRI: IDENTITAS & FILOSOFI --}}
            <div class="profile-identity-column">
                <div class="identity-sticky">
                    <span class="badge-serif">Ruang Anggota</span>
                    
                    {{-- AVATAR DENGAN BADGE PREMIUM --}}
                    <div class="avatar-ring-editorial">
                        @if(auth()->user()->avatar_url)
                            <img src="{{ asset('storage/' . auth()->user()->avatar_url) }}" alt="{{ auth()->user()->full_name }}" class="editorial-avatar-img">
                        @else
                            {{-- Lencana Inisial Premium --}}
                            <div class="editorial-avatar-initials">
                                <span>
                                    {{ collect(explode(' ', auth()->user()->full_name ?? auth()->user()->username))->map(function($name) { return strtoupper(substr($name, 0, 1)); })->take(2)->implode(' ') }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <h1 class="editorial-greeting">Halo,<br><i class="serif-accent">{{ explode(' ', auth()->user()->full_name ?? auth()->user()->username)[0] ?? 'Guest' }}</i>.</h1>
                    
                    <div class="editorial-hairline"></div>
                    
                    <p class="editorial-philosophy">"Menyajikan simfoni rasa dalam setiap cangkir, dari kurasi biji pilihan hingga tegukan terakhir."</p>
                    <span class="philosophy-signature">Vybrasi Roastery</span>
                </div>
            </div>

            {{-- KOLOM KANAN: DAFTAR MENU MINIMALIS --}}
            <div class="profile-nav-column">
                <nav class="editorial-nav-list">
                    
                    <a href="{{ route('profil.view') }}" class="nav-list-item">
                        <span class="nav-item-number">01</span>
                        <span class="nav-item-text">Profil Saya</span>
                        <i class="fa-solid fa-arrow-right-long nav-item-arrow"></i>
                    </a>
                    
                    <a href="{{ route('pesanan.riwayat') }}" class="nav-list-item">
                        <span class="nav-item-number">02</span>
                        <span class="nav-item-text">Riwayat Pesanan</span>
                        <i class="fa-solid fa-arrow-right-long nav-item-arrow"></i>
                    </a>
                    
                    <a href="{{ route('keranjang.index') }}" class="nav-list-item">
                        <span class="nav-item-number">03</span>
                        <span class="nav-item-text">Keranjang Saya</span>
                        <i class="fa-solid fa-arrow-right-long nav-item-arrow"></i>
                    </a>
                    
                    {{-- Tombol Logout --}}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class="nav-list-item logout-list-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="nav-item-number">04</span>
                        <span class="nav-item-text">Keluar Akun</span>
                        <i class="fa-solid fa-power-off nav-item-arrow"></i>
                    </a>
                    
                </nav>
            </div>

        </div>

    </div>
</div>
@endsection