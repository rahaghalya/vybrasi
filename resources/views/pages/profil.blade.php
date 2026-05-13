@extends('layouts.app')

@section('title', 'Vybrasi - Menu Profil')

@section('content')
<div class="profil-page-container">
    <div class="profil-card">
        
        <div class="profil-header">
            {{-- Cek apakah user memiliki avatar di database --}}
            @if(auth()->user()->avatar_url)
                <img src="{{ asset('storage/' . auth()->user()->avatar_url) }}" alt="{{ auth()->user()->full_name }}" class="profil-avatar" style="object-fit: cover;">
            @else
                <img src="{{ asset('images/avatar.png') }}" alt="{{ auth()->user()->full_name }}" class="profil-avatar">
            @endif
            
            {{-- Menampilkan nama lengkap dari database --}}
            <h2 class="profil-name">{{ auth()->user()->full_name ?? 'Pengguna Vybrasi' }}</h2>
        </div>

        <hr class="profil-divider">

        <div class="profil-menu">
            <a href="{{ route('profil.view') }}" class="profil-menu-item">
                <i class="fa-regular fa-user"></i>
                <span>Profil Saya</span>
            </a>
            
            <a href="{{ route('pesanan.riwayat') }}" class="profil-menu-item">
                <i class="fa-solid fa-file-invoice"></i>
                <span>Riwayat Pesanan</span>
            </a>
            
            <a href="{{ route('keranjang.index') }}" class="profil-menu-item">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Keranjang Saya</span>
            </a>
            
            {{-- Tombol Logout yang memicu form tersembunyi --}}
            <a href="#" class="profil-menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-power-off"></i>
                <span>Keluar</span>
            </a>
            
            {{-- Form tersembunyi untuk proses POST Logout --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

    </div>
</div>
@endsection