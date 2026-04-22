@extends('layouts.app')

@section('title', 'Vybrasi - Profil Saya')

@section('content')
<div class="profil-page-container">
    <div class="profil-card">
        
        <div class="profil-header">
            <img src="{{ asset('images/avatar.png') }}" alt="Fadil Prasetyo" class="profil-avatar">
            <h2 class="profil-name">Fadil Prasetyo</h2>
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
            
            <a href="#" class="profil-menu-item">
                <i class="fa-solid fa-power-off"></i>
                <span>Keluar</span>
            </a>
        </div>

    </div>
</div>
@endsection