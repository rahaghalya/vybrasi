@extends('layouts.app')

@section('title', 'Vybrasi - Profil Saya')

@section('content')
<div class="vy-luxury-edit-wrapper">
    <div class="editorial-form-container fade-in-up">
        
        {{-- TOMBOL KEMBALI --}}
        <a href="{{ route('profil') }}" class="btn-back-hairline">
            <i class="fa-solid fa-arrow-left-long"></i>
            <span>Menu Profil</span>
        </a>

        {{-- HEADER --}}
        <div class="form-editorial-header">
            <span class="badge-serif">Personal Dossier</span>
            <h1 class="editorial-page-title">Profil<br><i class="serif-accent">Saya.</i></h1>
            <div class="editorial-hairline"></div>
        </div>

        {{-- AVATAR SECTION DENGAN BADGE PREMIUM & IDENTITAS --}}
        <div class="editorial-avatar-section">
            <div class="avatar-ring-premium">
                @if(auth()->user()->avatar_url)
                    <img src="{{ asset('storage/' . auth()->user()->avatar_url) }}" alt="Avatar" class="premium-avatar-img">
                @else
                    {{-- Badge Inisial Premium --}}
                    <div class="initials-badge-luxury">
                        <span>
                            {{ collect(explode(' ', auth()->user()->full_name ?? auth()->user()->username))->map(function($name) { return strtoupper(substr($name, 0, 1)); })->take(2)->implode(' ') }}
                        </span>
                    </div>
                @endif
            </div>
            
            <div class="identity-text-box">
                <h2 class="dossier-name-heading">{{ auth()->user()->full_name ?? 'Pengguna Vybrasi' }}</h2>
                <a href="{{ route('profil.edit') }}" class="btn-hairline-action">
                    <i class="fa-regular fa-pen-to-square"></i> Sunting Data
                </a>
            </div>
        </div>

        {{-- DATA DOSSIER (TIPOGRAFI MURNI, BUKAN INPUT BOX) --}}
        <div class="editorial-data-sheet">
            <div class="sheet-grid-layout">
                
                <div class="dossier-group full-width">
                    <span class="dossier-label">Nama Lengkap</span>
                    <p class="dossier-value">{{ auth()->user()->full_name ?? 'Belum diisi' }}</p>
                </div>

                <div class="dossier-group">
                    <span class="dossier-label">Username</span>
                    <p class="dossier-value">{{ auth()->user()->username ?? 'Belum diisi' }}</p>
                </div>

                <div class="dossier-group">
                    <span class="dossier-label">Alamat Email</span>
                    <p class="dossier-value">{{ auth()->user()->email }}</p>
                </div>

                <div class="dossier-group">
                    <span class="dossier-label">Nomor Telepon</span>
                    <p class="dossier-value">{{ auth()->user()->phone ?? 'Belum diisi' }}</p>
                </div>

                <div class="dossier-group">
                    <span class="dossier-label">Tanggal Lahir</span>
                    <p class="dossier-value">{{ auth()->user()->tanggal_lahir ? \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->translatedFormat('d F Y') : 'Belum diisi' }}</p>
                </div>

                <div class="dossier-group full-width">
                    <span class="dossier-label">Alamat Pengiriman Utama</span>
                    <p class="dossier-value address-value">
                        {{ isset($alamat) ? $alamat->alamat_lengkap . ', ' . $alamat->kota . ', ' . $alamat->provinsi . ' ' . $alamat->kode_pos : 'Belum ada alamat pengiriman terdaftar.' }}
                    </p>
                </div>

            </div>
        </div>
        
        {{-- FOOTER ALTERNATIF 2: BRAND PLEDGE --}}
<div class="dossier-footer-support">
    <div class="support-icon">
        <i class="fa-solid fa-gem"></i>
    </div>
    <div class="support-text">
        <span class="support-title">Vybrasi Exclusive Member</span>
        <p>Data pribadi Anda dilindungi dengan standar privasi tertinggi. Vybrasi berkomitmen penuh menjaga keamanan setiap tegukan cerita Anda.</p>
    </div>
</div>

    </div>
</div>
@endsection