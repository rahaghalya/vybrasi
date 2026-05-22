@extends('layouts.app')

@section('title', 'Vybrasi - Profil Saya')

@section('content')
<<<<<<< HEAD
<div class="edit-profil-container">
    <h1 class="page-title">Profil Saya</h1>

    <div class="edit-profil-card">
        <div class="edit-avatar-section">
            <div class="avatar-wrapper">
                {{-- Jika user punya avatar, tampilkan. Jika tidak, pakai avatar default --}}
                @if(auth()->user()->avatar_url)
                    <img src="{{ asset('storage/' . auth()->user()->avatar_url) }}" alt="Avatar Pengguna" style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover;">
                @else
                    <img src="{{ asset('images/avatar.png') }}" alt="Avatar Pengguna" style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover;">
                @endif
            </div>
            <a href="{{ route('profil.edit') }}" class="btn-ubah-avatar" style="text-decoration: none;">
                <i class="fa-regular fa-pen-to-square"></i> Ubah
            </a>
        </div>

        <div class="edit-profil-form">
            <div class="edit-form-grid">
                
                <div class="form-group" style="grid-column: span 2;">
                    <label>Nama Lengkap</label>
                    <div class="input-wrapper">
                        <input type="text" name="nama_lengkap" value="{{ auth()->user()->full_name ?? 'Belum diisi' }}" readonly>
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <input type="text" name="username" value="{{ auth()->user()->username ?? 'Belum diisi' }}" readonly>
                        <i class="fa-solid fa-at"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" value="{{ auth()->user()->email }}" readonly>
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>No. Telp</label>
                    <div class="input-wrapper">
                        <input type="text" name="no_telp" value="{{ auth()->user()->phone ?? 'Belum diisi' }}" readonly>
                        <i class="fa-solid fa-phone"></i>
                    </div>
                </div>

                {{-- FITUR BARU: Menampilkan Tanggal Lahir --}}
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="input-wrapper">
                        {{-- Menggunakan Carbon untuk memformat tanggal menjadi format lokal (contoh: 17 Agustus 1945) --}}
                        <input type="text" name="tanggal_lahir" value="{{ auth()->user()->tanggal_lahir ? \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->translatedFormat('d F Y') : 'Belum diisi' }}" readonly>
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>

                {{-- FITUR BARU: Menampilkan Alamat Utama (Gabungan) --}}
                <div class="form-group" style="grid-column: span 2;">
                    <label>Alamat Pengiriman Utama</label>
                    <div class="input-wrapper align-top">
                        <textarea rows="3" readonly placeholder="Belum ada alamat">{{ isset($alamat) ? $alamat->alamat_lengkap . ', ' . $alamat->kota . ', ' . $alamat->provinsi . ' ' . $alamat->kode_pos : 'Belum ada alamat pengiriman' }}</textarea>
                        <i class="fa-solid fa-location-dot" style="margin-top: 15px;"></i>
                    </div>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Kode Unik (Referal)</label>
                    <div class="input-wrapper">
                        <input type="text" name="kode_unik" value="{{ auth()->user()->kode_unik ?? 'Belum memiliki kode' }}" readonly>
                        <i class="fa-solid fa-hashtag"></i>
                    </div>
=======
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
>>>>>>> frontend-ui
                </div>

            </div>
        </div>
<<<<<<< HEAD
=======
        
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

>>>>>>> frontend-ui
    </div>
</div>
@endsection