@extends('layouts.app')

@section('title', 'Vybrasi - Edit Profil')

@section('content')
<div class="edit-profil-container">
    <h1 class="page-title">Profil Saya</h1>

    <div class="edit-profil-card">
        <div class="edit-avatar-section">
            <div class="avatar-wrapper">
                @if(auth()->user()->avatar_url)
                    <img src="{{ asset('storage/' . auth()->user()->avatar_url) }}" alt="Avatar" style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover;">
                @else
                    <i class="fa-solid fa-circle-user" style="font-size: 130px; color: #FFFFFF;"></i>
                @endif
            </div>
        </div>

        <form id="form-edit-profil" action="{{ route('profil.update') }}" method="POST" class="edit-profil-form">
            @csrf
            @method('PUT') 
            
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
                <div style="grid-column: span 2; margin-top: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                    <h3 style="color: #333; font-size: 16px;">Alamat Pengiriman</h3>
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
                        <input type="text" name="kota" value="{{ old('kota', $alamat->kota ?? '') }}" placeholder="Contoh: Surabaya">
                        <i class="fa-solid fa-city"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Kode Pos</label>
                    <div class="input-wrapper">
                        <input type="text" name="kode_pos" value="{{ old('kode_pos', $alamat->kode_pos ?? '') }}" placeholder="Contoh: 60111">
                        <i class="fa-solid fa-envelopes-bulk"></i>
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- UBAH PASSWORD                              --}}
                {{-- ========================================== --}}
                <div style="grid-column: span 2; margin-top: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                    <h3 style="color: #333; font-size: 16px;">Ubah Password</h3>
                    <p style="font-size: 12px; color: #888;">Kosongkan bagian ini jika Anda tidak ingin mengubah password.</p>
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

                {{-- Tombol dipindahkan ke dalam grid, diberi span 2 agar punya baris sendiri, 
                     dan flex-end agar posisinya rapi di sebelah kanan (atau hapus justify-content untuk posisi kiri) --}}
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
<div class="modal-overlay" id="customPopupOverlay">
    <div class="modal-box" id="popupBox">
        <div class="modal-icon" id="popupIcon"></div>
        <h3 class="modal-title" id="popupTitle"></h3>
        <p class="modal-text" id="popupMessage"></p>
        
        <div id="confirmActions" style="display: none; justify-content: center; gap: 10px; margin-top: 20px;">
            <button class="btn-cancel" onclick="closePopup()" style="background: #ccc; color: #333; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">Batal</button>
            <button class="btn-confirm" onclick="submitForm()" style="background: #D4A373; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">Ya, Simpan</button>
        </div>
        
        <div id="successActions" style="display: none; justify-content: center; margin-top: 20px;">
            <button class="btn-ok" onclick="closePopup()" style="background: #28a745; color: white; border: none; padding: 10px 30px; border-radius: 5px; cursor: pointer; font-weight: bold;">Mengerti</button>
        </div>
    </div>
</div>

<style>
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.7); display: flex; justify-content: center;
        align-items: center; z-index: 1000; opacity: 0; visibility: hidden; transition: all 0.3s ease;
    }
    .modal-overlay.active { opacity: 1; visibility: visible; }
    .modal-box {
        background: #fff; padding: 30px 40px; border-radius: 12px; text-align: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2); max-width: 400px; transform: translateY(-20px); transition: all 0.3s ease;
    }
    .modal-overlay.active .modal-box { transform: translateY(0); }
    .modal-icon { font-size: 48px; margin-bottom: 15px; }
    .modal-title { font-size: 22px; color: #333; margin-bottom: 10px; font-weight: bold; }
    .modal-text { font-size: 14px; color: #666; line-height: 1.6; margin-bottom: 0;}
    
    .modal-box.confirm { border-top: 5px solid #D4A373; }
    .modal-box.confirm .modal-icon { color: #D4A373; }
    .modal-box.success { border-top: 5px solid #28a745; }
    .modal-box.success .modal-icon { color: #28a745; }
</style>

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
        popupBox.className = 'modal-box confirm';
        popupIcon.innerHTML = '<i class="fa-solid fa-circle-question"></i>';
        popupTitle.innerText = 'Konfirmasi Perubahan';
        popupMessage.innerText = 'Apakah Anda yakin semua data yang dimasukkan sudah benar?';
        
        confirmActions.style.display = 'flex';
        successActions.style.display = 'none';
        
        popupOverlay.classList.add('active');
    }

    function submitForm() {
        document.querySelector('.btn-confirm').innerText = 'Menyimpan...';
        document.querySelector('.btn-confirm').disabled = true;
        form.submit();
    }

    function closePopup() {
        popupOverlay.classList.remove('active');
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            popupBox.className = 'modal-box success';
            popupIcon.innerHTML = '<i class="fa-solid fa-circle-check"></i>';
            popupTitle.innerText = 'Berhasil!';
            popupMessage.innerText = '{{ session('success') }}';
            
            confirmActions.style.display = 'none';
            successActions.style.display = 'flex';
            
            popupOverlay.classList.add('active');
        @endif
    });
</script>
@endsection