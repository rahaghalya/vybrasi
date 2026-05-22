<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vybrasi - Pemulihan Akun</title>
    <link rel="stylesheet" href="{{ asset('css-admin/daftar.css') }}">
    
    {{-- Pastikan FontAwesome dimuat --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CSS KHUSUS UNTUK POP-UP CUSTOM (Konsisten dengan Login) */
        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.7); display: flex;
            justify-content: center; align-items: center;
            z-index: 1000; opacity: 0; visibility: hidden; transition: all 0.3s ease;
        }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        .modal-box {
            background: #fff; padding: 30px 40px; border-radius: 12px;
            text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            max-width: 400px; transform: translateY(-20px); transition: all 0.3s ease;
        }
        .modal-overlay.active .modal-box { transform: translateY(0); }
        .modal-icon { font-size: 48px; margin-bottom: 15px; }
        .modal-title { font-size: 22px; color: #333; margin-bottom: 10px; font-weight: bold; }
        .modal-text { font-size: 14px; color: #666; margin-bottom: 20px; line-height: 1.6; }
        .btn-close-modal {
            background: #D4A373; color: white; border: none; padding: 10px 30px;
            border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 14px; transition: background 0.3s;
        }
        .btn-close-modal:hover { background: #b58b61; }
        
        .modal-box.error { border-top: 5px solid #C25953; }
        .modal-box.error .modal-icon { color: #C25953; }
        .modal-box.success { border-top: 5px solid #28a745; }
        .modal-box.success .modal-icon { color: #28a745; }
        .error-message { color: #C25953; font-size: 12px; margin-top: 5px; display: block; }

        /* --- CSS KHUSUS HALAMAN LUPA PASSWORD --- */
        .desc-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 25px;
            line-height: 1.6;
            text-align: center;
        }
        .back-to-login {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
            font-size: 14px;
            color: #888;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .back-to-login:hover {
            color: #D4A373;
        }

        /* CSS FITUR INTIP PASSWORD */
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-wrapper input {
            width: 100%;
            padding-right: 40px; 
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            cursor: pointer;
            color: #888;
            font-size: 18px;
            transition: color 0.3s ease;
        }
        .toggle-password:hover {
            color: #D4A373; 
        }
    </style>
</head>
<body>
    <div class="register-container">
        
        {{-- Sisi Kiri / Hero --}}
        <div class="hero-section">
            <h1 class="hero-text">Pulihkan<br>Akses<br>Kopimu</h1>
        </div>

        {{-- Sisi Kanan / Form --}}
        <div class="form-section">
            <div class="register-box">
                <h2>Ubah Password</h2>
                <p class="desc-text">Masukkan email akun Anda dan tentukan password baru yang ingin digunakan.</p>
                
                {{-- Form Reset Langsung Sementara untuk Testing --}}
                <form action="{{ route('password.update.langsung') }}" method="POST">
                    @csrf 
                    
                    <div class="form-group">
                        <label for="email">Email Terdaftar</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder="Masukkan password baru" required>
                            <i class="fa-solid fa-eye-slash toggle-password" id="togglePasswordBtn" title="Lihat Password"></i>
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-register" style="margin-top: 20px;">Ubah Password Sekarang</button>

                    <a href="{{ route('login') }}" class="back-to-login">
                        <i class="fa-solid fa-arrow-left-long"></i> Kembali ke Login
                    </a>
                </form>
                
            </div>
        </div>

    </div>

    {{-- Modal Pop-up untuk Notifikasi --}}
    <div class="modal-overlay" id="customModal">
        <div class="modal-box" id="modalBox">
            <div class="modal-icon" id="modalIcon"></div>
            <h3 class="modal-title" id="modalTitle"></h3>
            <p class="modal-text" id="modalMessage"></p>
            <button class="btn-close-modal" onclick="closeModal()">Mengerti</button>
        </div>
    </div>

    <script>
        // --- LOGIKA FITUR SHOW / HIDE PASSWORD ---
        document.addEventListener('DOMContentLoaded', function () {
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    
                    // Ubah tipe input password dan konfirmasinya sekaligus
                    passwordInput.setAttribute('type', type);
                    passwordConfirmInput.setAttribute('type', type);
                    
                    // Ganti ikon mata
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });

        // --- FUNGSI MODAL ---
        function showModal(title, message, type = 'error') {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalMessage').innerText = message;
            
            const modalBox = document.getElementById('modalBox');
            const modalIcon = document.getElementById('modalIcon');

            if(type === 'success') {
                modalBox.className = 'modal-box success';
                modalIcon.innerText = '✅';
            } else {
                modalBox.className = 'modal-box error';
                modalIcon.innerText = '⚠️';
            }

            document.getElementById('customModal').className = 'modal-overlay active';
        }

        function closeModal() {
            document.getElementById('customModal').className = 'modal-overlay';
        }

        // Catch Error Bawaan Validasi Controller
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                showModal("Berhasil!", "{{ session('success') }}", 'success');
            @elseif($errors->any())
                showModal("Gagal Mengubah", "{{ $errors->first() }}", 'error');
            @endif
        });
    </script>
</body>
<<<<<<< HEAD
</html>
=======
</html> 
>>>>>>> frontend-ui
