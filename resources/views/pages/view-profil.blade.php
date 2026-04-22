@extends('layouts.app')

@section('title', 'Vybrasi - Profil Saya')

@section('content')
<div class="edit-profil-container">
    <h1 class="page-title">Profil Saya</h1>

    <div class="edit-profil-card">
        <div class="edit-avatar-section">
            <div class="avatar-wrapper">
                <img src="{{ asset('images/avatar.png') }}" alt="Avatar Pengguna">
            </div>
            <a href="{{ route('profil.edit') }}" class="btn-ubah-avatar" style="text-decoration: none;">
                <i class="fa-regular fa-pen-to-square"></i> Ubah
            </a>
        </div>

        <div class="edit-profil-form">
            <div class="edit-form-grid">
                
                <div class="form-group">
                    <label>Nama Depan</label>
                    <div class="input-wrapper">
                        <input type="text" name="nama_depan" value="Fadil" readonly>
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Belakang</label>
                    <div class="input-wrapper">
                        <input type="text" name="nama_belakang" value="Prasetyo" readonly>
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" value="fdlrasetyo@gmail.com" readonly>
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>No. Telp</label>
                    <div class="input-wrapper">
                        <input type="text" name="no_telp" value="084536271890" readonly>
                        <i class="fa-solid fa-phone"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="input-wrapper">
                        <input type="text" name="tanggal_lahir" value="29/02/2005" readonly>
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <div class="input-wrapper align-top">
                        <textarea name="alamat" rows="4" readonly>Jl. Durian, No. 108, Surabaya, Jawa Timur. (Rumah Paling Bagus)</textarea>
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                </div>

            </div>
        </div>
        </div>
</div>
@endsection