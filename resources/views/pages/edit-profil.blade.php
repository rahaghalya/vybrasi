@extends('layouts.app')

@section('title', 'Vybrasi - Edit Profil')

@section('content')
<div class="edit-profil-container">
    <h1 class="page-title">Profil Saya</h1>

    <div class="edit-profil-card">
        <div class="edit-avatar-section">
            <div class="avatar-wrapper">
                <i class="fa-solid fa-circle-user" style="font-size: 130px; color: #FFFFFF;"></i>
            </div>
        </div>

        <form action="#" method="POST" class="edit-profil-form">
            @csrf
            <div class="edit-form-grid">
                
                <div class="form-group">
                    <label>Nama Depan</label>
                    <div class="input-wrapper">
                        <input type="text" name="nama_depan" placeholder="masukan nama anda">
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Belakang</label>
                    <div class="input-wrapper">
                        <input type="text" name="nama_belakang" placeholder="masukan nama anda">
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" placeholder="masukan email anda">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>No. Telp</label>
                    <div class="input-wrapper">
                        <input type="text" name="no_telp" placeholder="masukan no.telp anda">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="input-wrapper">
                        <input type="text" name="tanggal_lahir" placeholder="pilih tanggal lahir anda">
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <div class="input-wrapper align-top">
                        <textarea name="alamat" rows="4" placeholder="masukan alamat lengkap anda"></textarea>
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                </div>

            </div>
            
           <div class="form-action">
    <button type="submit" class="btn-simpan-profil">
        <span>Simpan Perubahan</span>
        <i class="fa-solid fa-check-double"></i>
    </button>
</div>
        </form>
    </div>
</div>
@endsection