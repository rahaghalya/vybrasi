@extends('layouts.app')

@section('title', 'Vybrasi - Edit Profil')

@section('content')
<div class="edit-profil-container">
    
    {{-- TOMBOL KEMBALI KE VIEW PROFIL --}}
    <a href="{{ route('profil.view') }}" class="btn-back-hairline" style="align-self: flex-start; margin-bottom: 20px;">
        <i class="fa-solid fa-arrow-left-long"></i>
        <span>Lihat Profil</span>
    </a>

    <h1 class="page-title">Profil Saya</h1>

    <div class="edit-profil-card">
        
        {{-- PENTING: enctype="multipart/form-data" WAJIB untuk upload foto --}}
        <form id="form-edit-profil" action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="edit-profil-form">
            @csrf
            @method('PUT') 

            {{-- AVATAR SECTION --}}
            <div class="edit-avatar-section" style="flex-direction: column; align-items: center; gap: 20px;">
                <div class="avatar-wrapper">
                    @if(auth()->user()->avatar_url)
                        <img src="{{ asset('storage/' . auth()->user()->avatar_url) }}" alt="Avatar" style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover;">
                    @else
                        {{-- Lencana Inisial Premium jika belum ada foto --}}
                        <div class="initials-badge-luxury" style="width: 100%; height: 100%; border-radius: 50%; background-color: var(--vy-pine); display: flex; justify-content: center; align-items: center; position: relative; overflow: hidden;">
                            <span style="font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 400; letter-spacing: -2px; color: var(--vy-cream);">
                                {{ collect(explode(' ', auth()->user()->full_name ?? auth()->user()->username))->map(function($name) { return strtoupper(substr($name, 0, 1)); })->take(2)->implode(' ') }}
                            </span>
                        </div>
                    @endif
                </div>
                
                {{-- INPUT UPLOAD FOTO PROFIL --}}
                <div class="avatar-upload-container">
                    <input type="file" name="avatar" id="avatar-upload" class="avatar-file-input" accept="image/*" onchange="previewImage(this)">
                    
                    <label for="avatar-upload" class="btn-hairline-action">
                        <i class="fa-solid fa-camera"></i> Ganti Foto Profil
                    </label>
                    @error('avatar') <small style="color: red; margin-top: 8px; display: block; text-align: center;">{{ $message }}</small> @enderror
                </div>
            </div>
            
            <div class="edit-form-grid">
                
                {{-- DATA PROFIL --}}
                <div class="form-group" style="grid-column: span 2;">
                    <label>Nama Lengkap</label>
                    <div class="input-wrapper">
                        <input type="text" name="full_name" value="{{ old('full_name', auth()->user()->full_name) }}" placeholder="masukan nama lengkap anda" required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                    @error('full_name') <small style="color: red;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}" placeholder="masukan username unik" required>
                        <i class="fa-solid fa-at"></i>
                    </div>
                    @error('username') <small style="color: red;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" placeholder="masukan email anda" required>
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    @error('email') <small style="color: red;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>No. Telp</label>
                    <div class="input-wrapper">
                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="masukan no.telp anda">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    @error('phone') <small style="color: red;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="input-wrapper">
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', auth()->user()->tanggal_lahir ? \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->format('Y-m-d') : '') }}">
                        <i class="fa-regular fa-calendar" style="pointer-events: none;"></i>
                    </div>
                    @error('tanggal_lahir') <small style="color: red;">{{ $message }}</small> @enderror
                </div>

                {{-- ========================================== --}}
                {{-- ALAMAT PENGIRIMAN                          --}}
                {{-- ========================================== --}}
                <div style="grid-column: span 2; margin-top: 15px; border-bottom: 1px solid rgba(27, 22, 22, 0.1); padding-bottom: 10px;">
                    <h3 style="color: var(--vy-pine); font-size: 16px; font-family: 'Playfair Display', serif; margin: 0;">Alamat Pengiriman</h3>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Alamat Lengkap</label>
                    <div class="input-wrapper align-top">
                        <textarea name="alamat_lengkap" rows="3" placeholder="Nama Jalan, Gedung, No. Rumah, RT/RW">{{ old('alamat_lengkap', $alamat->alamat_lengkap ?? '') }}</textarea>
                        <i class="fa-solid fa-location-dot" style="margin-top: 15px;"></i>
                    </div>
                    @error('alamat_lengkap') <small style="color: red;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Provinsi</label>
                    <div class="input-wrapper">
                        <input type="text" name="provinsi" value="{{ old('provinsi', $alamat->provinsi ?? '') }}" placeholder="Contoh: Jawa Timur">
                        <i class="fa-solid fa-map"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Kota / Kabupaten</label>
                    <div class="input-wrapper">
                        <input type="text" name="kota" value="{{ old('kota', $alamat->kota ?? '') }}" placeholder="Contoh: Sidoarjo">
                        <i class="fa-solid fa-city"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Kode Pos</label>
                    <div class="input-wrapper">
                        <input type="text" name="kode_pos" value="{{ old('kode_pos', $alamat->kode_pos ?? '') }}" placeholder="Contoh: 61253">
                        <i class="fa-solid fa-envelopes-bulk"></i>
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- UBAH PASSWORD                              --}}
                {{-- ========================================== --}}
                <div style="grid-column: span 2; margin-top: 15px; border-bottom: 1px solid rgba(27, 22, 22, 0.1); padding-bottom: 10px;">
                    <h3 style="color: var(--vy-pine); font-size: 16px; font-family: 'Playfair Display', serif; margin: 0 0 5px 0;">Ubah Password</h3>
                    <p style="font-size: 12px; color: rgba(27, 22, 22, 0.5); font-family: 'Montserrat', sans-serif; margin: 0;">Kosongkan bagian ini jika Anda tidak ingin mengubah password.</p>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Password Lama</label>
                    <div class="input-wrapper">
                        <input type="password" name="old_password" placeholder="Masukan password lama Anda">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    @error('old_password') <small style="color: red;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" placeholder="Masukan password baru">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    @error('password') <small style="color: red;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <div class="input-wrapper">
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                </div>

                {{-- TOMBOL SIMPAN --}}
                <div class="form-action" style="grid-column: span 2; margin-top: 15px; display: flex; justify-content: flex-end;">
                    <button type="button" class="btn-simpan-profil" onclick="showConfirmPopup()" style="width: max-content; padding: 12px 24px;">
                        <span>Simpan Perubahan</span>
                        <i class="fa-solid fa-check-double"></i>
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- STRUKTUR POP-UP CUSTOM --}}
<div class="modal-overlay" id="customPopupOverlay" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.7); display: flex; justify-content: center; align-items: center; z-index: 1000; opacity: 0; visibility: hidden; transition: all 0.3s ease;">
    <div class="modal-box" id="popupBox" style="background: var(--vy-cream); padding: 30px 40px; border-radius: 12px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.2); max-width: 400px; transform: translateY(-20px); transition: all 0.3s ease; border: 1px solid rgba(27, 22, 22, 0.1);">
        <div class="modal-icon" id="popupIcon" style="font-size: 48px; margin-bottom: 15px;"></div>
        <h3 class="modal-title" id="popupTitle" style="font-family: 'Playfair Display', serif; font-size: 26px; color: var(--vy-pine); margin-bottom: 10px; font-weight: bold;"></h3>
        <p class="modal-text" id="popupMessage" style="font-family: 'Montserrat', sans-serif; font-size: 14px; color: rgba(27, 22, 22, 0.7); line-height: 1.6; margin-bottom: 0;"></p>
        
        <div id="confirmActions" style="display: none; justify-content: center; gap: 10px; margin-top: 20px;">
            <button class="btn-cancel" onclick="closePopup()" style="background: transparent; color: var(--vy-pine); border: 1px solid var(--vy-pine); padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; font-family: 'Montserrat', sans-serif; font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em;">Batal</button>
            <button class="btn-confirm" onclick="submitForm()" style="background: var(--vy-sage); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; font-family: 'Montserrat', sans-serif; font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em;">Ya, Simpan</button>
        </div>
        
        <div id="successActions" style="display: none; justify-content: center; margin-top: 20px;">
            <button class="btn-ok" onclick="closePopup()" style="background: var(--vy-sage); color: white; border: none; padding: 10px 30px; border-radius: 5px; cursor: pointer; font-weight: bold; font-family: 'Montserrat', sans-serif; font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em;">Mengerti</button>
        </div>
    </div>
</div>

<script>
    const popupOverlay = document.getElementById('customPopupOverlay');
    const popupBox = document.getElementById('popupBox');
    const popupIcon = document.getElementById('popupIcon');
    const popupTitle = document.getElementById('popupTitle');
    const popupMessage = document.getElementById('popupMessage');
    const confirmActions = document.getElementById('confirmActions');
    const successActions = document.getElementById('successActions');
    const form = document.getElementById('form-edit-profil');

    function showConfirmPopup() {
        popupBox.style.borderTop = '5px solid var(--vy-sage)';
        popupIcon.innerHTML = '<i class="fa-solid fa-circle-question" style="color: var(--vy-sage);"></i>';
        popupTitle.innerText = 'Konfirmasi Perubahan';
        popupMessage.innerText = 'Apakah Anda yakin semua data yang dimasukkan sudah benar?';
        
        confirmActions.style.display = 'flex';
        successActions.style.display = 'none';
        
        popupOverlay.style.opacity = '1';
        popupOverlay.style.visibility = 'visible';
        popupBox.style.transform = 'translateY(0)';
    }

    function submitForm() {
        document.querySelector('.btn-confirm').innerText = 'Menyimpan...';
        document.querySelector('.btn-confirm').disabled = true;
        form.submit();
    }

    function closePopup() {
        popupOverlay.style.opacity = '0';
        popupOverlay.style.visibility = 'hidden';
        popupBox.style.transform = 'translateY(-20px)';
    }

    // Fungsi Preview Gambar
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var avatarContainer = document.querySelector('.avatar-wrapper');
                avatarContainer.innerHTML = '<img src="' + e.target.result + '" alt="Avatar Preview" style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover;">';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            popupBox.style.borderTop = '5px solid #28a745';
            popupIcon.innerHTML = '<i class="fa-solid fa-circle-check" style="color: #28a745;"></i>';
            popupTitle.innerText = 'Berhasil!';
            popupMessage.innerText = '{{ session('success') }}';
            
            confirmActions.style.display = 'none';
            successActions.style.display = 'flex';
            
            popupOverlay.style.opacity = '1';
            popupOverlay.style.visibility = 'visible';
            popupBox.style.transform = 'translateY(0)';
        @endif
    });
</script>
@endsection