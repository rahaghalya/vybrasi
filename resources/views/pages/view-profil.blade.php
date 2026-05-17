@extends('layouts.app')

@section('title', 'Vybrasi - Profil Saya')

@section('content')
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
                </div>

            </div>
        </div>
    </div>
</div>
@endsection