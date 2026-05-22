<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vybrasi - Login</title>
    <link rel="stylesheet" href="{{ asset('css-admin/daftar.css') }}">
    
<<<<<<< HEAD
    {{-- Pastikan FontAwesome dimuat --}}
=======
    {{-- Pastikan FontAwesome dimuat (Jika di daftar.css belum ada) --}}
>>>>>>> frontend-ui
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CSS KHUSUS UNTUK POP-UP CUSTOM */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .modal-box {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            max-width: 400px;
            transform: translateY(-20px);
            transition: all 0.3s ease;
        }
        .modal-overlay.active .modal-box {
            transform: translateY(0);
        }
        .modal-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .modal-title {
            font-size: 22px;
            color: #333;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .modal-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .btn-close-modal {
            background: #D4A373;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn-close-modal:hover {
            background: #b58b61;
        }
        
        /* Tema Error */
        .modal-box.error { border-top: 5px solid #C25953; }
        .modal-box.error .modal-icon { color: #C25953; }
        
        /* Tema Sukses */
        .modal-box.success { border-top: 5px solid #28a745; }
        .modal-box.success .modal-icon { color: #28a745; }

        /* CSS Jika ada error dari validasi form bawaan laravel */
        .error-message {
            color: #C25953;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        /* --- CSS BARU UNTUK FITUR SHOW PASSWORD --- */
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-wrapper input {
            width: 100%;
<<<<<<< HEAD
            padding-right: 40px; 
=======
            padding-right: 40px; /* Memberi ruang agar teks tidak tertutup ikon */
>>>>>>> frontend-ui
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
<<<<<<< HEAD
            color: #D4A373; 
        }

        /* --- CSS BARU UNTUK LINK LUPA PASSWORD --- */
        .forgot-password-link {
            display: block;
            text-align: right;
            margin-top: 8px;
            font-size: 13px;
            color: #D4A373;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .forgot-password-link:hover {
            color: #b58b61;
            text-decoration: underline;
=======
            color: #D4A373; /* Berubah warna karamel saat di-hover */
>>>>>>> frontend-ui
        }
    </style>
</head>
<body>
    <div class="register-container">
        
        <div class="hero-section">
            <h1 class="hero-text">Mulai<br>Perjalanan<br>Kopimu</h1>
        </div>

        <div class="form-section">
            <div class="register-box">
                <h2>Login</h2>
                
                <form action="{{ route('login.proses') }}" method="POST">
                    @csrf 
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukan email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
<<<<<<< HEAD
=======
                        {{-- PERUBAHAN: Input password dibungkus untuk menaruh ikon mata --}}
>>>>>>> frontend-ui
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder="Masukan password" required>
                            <i class="fa-solid fa-eye-slash toggle-password" id="togglePasswordBtn" title="Lihat Password"></i>
                        </div>
<<<<<<< HEAD
                        {{-- LINK LUPA PASSWORD DITAMBAHKAN DI SINI --}}
                        <a href="{{ url('/lupa-password') }}" class="forgot-password-link">Lupa Password?</a>
=======
>>>>>>> frontend-ui
                    </div>

                    <div class="auth-link-container">
                        <span class="auth-link-text">Belum punya akun? <a href="{{ route('daftar') }}">Daftar</a></span>
                    </div>

                    <button type="submit" class="btn-register" id="btnLogin">Login</button>
                </form>
                
            </div>
        </div>

    </div>

    {{-- Modal Pop-up --}}
    <div class="modal-overlay" id="customModal">
        <div class="modal-box" id="modalBox">
            <div class="modal-icon" id="modalIcon"></div>
            <h3 class="modal-title" id="modalTitle"></h3>
            <p class="modal-text" id="modalMessage"></p>
            <button class="btn-close-modal" onclick="closeModal()">Mengerti</button>
        </div>
    </div>

    <script>
        // --- LOGIKA BARU UNTUK FITUR SHOW PASSWORD ---
        document.addEventListener('DOMContentLoaded', function () {
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function () {
<<<<<<< HEAD
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
=======
                    // Cek tipe input saat ini
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Ganti ikon mata (eye) ke mata dicoret (eye-slash)
>>>>>>> frontend-ui
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });

<<<<<<< HEAD
        // --- FUNGSI MODAL ---
=======
        // --- FUNGSI MODAL (TIDAK DIUBAH) ---
>>>>>>> frontend-ui
        function showModal(title, message, type = 'error', isBlocked = false) {
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

            document.getElementById('customModal').classList.add('active');
            
            if(isBlocked) {
                document.getElementById('email').disabled = true;
                document.getElementById('password').disabled = true;
                document.getElementById('btnLogin').disabled = true;
                document.getElementById('btnLogin').style.background = '#ccc';
            }
        }

        function closeModal() {
            document.getElementById('customModal').classList.remove('active');
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                showModal("Berhasil!", "{{ session('success') }}", 'success');
            @elseif(session('error_popup'))
                showModal("Akses Diblokir", "{{ session('error_popup') }}", 'error', true);
            @elseif($errors->any())
                showModal("Login Gagal", "Email atau password yang Anda masukkan salah. Sisa percobaan terbatas.", 'error');
            @endif
        });
    </script>
</body>
</html>