<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vybrasi - Masuk ke Akun</title>
    
    {{-- FontAwesome & Google Fonts --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
</head>
<body>

    {{-- ===================================================
         [HTML] HALAMAN LOGIN (SPLIT-SCREEN EDITORIAL)
         =================================================== --}}
    <div class="vy-split-layout">
        
        {{-- SISI KIRI: BRANDING (PINE) --}}
        <div class="vy-split-brand">
            <div class="brand-content-wrapper">
                <div class="brand-logo-text">Vybrasi.</div>
                <h1 class="brand-headline">Eksplorasi<br><i class="serif-accent">Rasa.</i></h1>
                <p class="brand-description">
                    Temukan perpaduan sempurna dan kurasi biji kopi pilihan terbaik untuk setiap seduhan Anda. Masuk untuk melanjutkan perjalanan.
                </p>
            </div>
            {{-- Elemen dekoratif --}}
            <div class="brand-decorative-line"></div>
        </div>

        {{-- SISI KANAN: FORM (CREAM) --}}
        <div class="vy-split-form">
            <div class="form-container fade-in-up">
                
                {{-- HEADER FORM --}}
                <div class="auth-header-editorial">
                    <span class="badge-serif">Akses Akun</span>
                    <h2 class="editorial-form-title">Selamat Datang</h2>
                </div>

                {{-- INLINE NOTIFICATION (Pengganti Pop-up) --}}
                <div id="inlineAlert" class="alert-message-luxury" style="display: none;">
                    <i id="alertIcon" class="fa-solid fa-circle-exclamation"></i>
                    <span id="alertText">Pesan di sini</span>
                </div>

                {{-- FORM LOGIN --}}
                <form action="{{ route('login.proses') }}" method="POST" class="auth-form" id="loginForm">
                    @csrf

                    {{-- Input Email --}}
                    <div class="form-group-hairline">
                        <label for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" class="input-hairline" placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="error-message-inline">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Password dengan Toggle Mata --}}
                    <div class="form-group-hairline">
                        <label for="password">Kata Sandi</label>
                        <div class="password-wrapper-luxury">
                            <input type="password" name="password" id="password" class="input-hairline input-password" placeholder="Masukkan password Anda" required>
                            <i class="fa-solid fa-eye-slash toggle-password-icon" id="togglePasswordBtn" title="Lihat Password"></i>
                        </div>
                    </div>

                    {{-- Link Daftar --}}
                    <div class="auth-options">
                        <span class="auth-link-text">Belum punya akun? <a href="{{ route('daftar') }}" class="auth-link-bold">Daftar</a></span>
                    </div>

                    {{-- Tombol Masuk --}}
                    <div class="auth-actions">
                        <button type="submit" class="btn-checkout-pill auth-btn-full" id="btnLogin">
                            Masuk Sekarang <i class="fa-solid fa-arrow-right-long" style="margin-left: 8px;"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    {{-- ===================================================
         [JAVASCRIPT] LOGIKA INTERAKSI
         =================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- LOGIKA SHOW/HIDE PASSWORD ---
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            // --- TRIGGER INLINE ALERT DARI SESSION LARAVEL ---
            @if(session('success'))
                showAlert("{{ session('success') }}", 'success');
            @elseif(session('error_popup'))
                showAlert("Akses Diblokir: {{ session('error_popup') }}", 'error', true);
            @elseif($errors->any())
                showAlert("Email atau password yang Anda masukkan salah.", 'error');
            @endif
        });

        // --- FUNGSI INLINE ALERT (PENGGANTI POP-UP) ---
        function showAlert(message, type = 'error', isBlocked = false) {
            const alertBox = document.getElementById('inlineAlert');
            const alertText = document.getElementById('alertText');
            const alertIcon = document.getElementById('alertIcon');

            alertText.innerText = message;
            
            if(type === 'success') {
                alertBox.className = 'alert-message-luxury alert-success';
                alertIcon.className = 'fa-solid fa-circle-check';
            } else {
                alertBox.className = 'alert-message-luxury alert-error';
                alertIcon.className = 'fa-solid fa-circle-exclamation';
            }

            alertBox.style.display = 'flex';
            
            if(isBlocked) {
                document.getElementById('email').disabled = true;
                document.getElementById('password').disabled = true;
                const btnLogin = document.getElementById('btnLogin');
                btnLogin.disabled = true;
                btnLogin.style.background = 'transparent';
                btnLogin.style.color = 'rgba(26, 47, 36, 0.4)';
                btnLogin.style.boxShadow = 'inset 0 0 0 1px rgba(26, 47, 36, 0.2)';
                btnLogin.style.cursor = 'not-allowed';
                btnLogin.innerHTML = 'Akses Terkunci <i class="fa-solid fa-lock" style="margin-left: 8px;"></i>';
            }
        }
    </script>

    {{-- ===================================================
         [CSS] STYLE EDITORIAL MINIMALIS (SPLIT-SCREEN)
         =================================================== --}}
    <style>
        /* RESET DASAR & 2 VARIABEL UTAMA */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            --vy-cream: #F2EBE1; /* Kanvas Bersih */
            --vy-pine: #1A2F24;  /* Hijau Telomoyo */
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--vy-cream);
            color: var(--vy-pine);
            overflow: hidden; /* Mencegah scroll jika tidak perlu */
        }

        /* --- LAYOUT SPLIT SCREEN --- */
        .vy-split-layout {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* Sisi Kiri (Brand) */
        .vy-split-brand {
            flex: 1; /* Mengambil proporsi seimbang */
            background-color: var(--vy-pine);
            color: var(--vy-cream);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .brand-content-wrapper {
            max-width: 500px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .brand-logo-text {
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            margin-bottom: 60px;
            opacity: 0.8;
        }

        .brand-headline {
            font-family: 'Playfair Display', serif;
            font-size: 4.5rem;
            font-weight: 300;
            line-height: 1.1;
            margin-bottom: 30px;
            letter-spacing: -2px;
        }

        .serif-accent {
            font-style: italic;
            font-weight: 500;
        }

        .brand-description {
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            line-height: 1.8;
            opacity: 0.7;
            max-width: 400px;
        }

        /* Garis dekoratif vertikal di sisi kiri */
        .brand-decorative-line {
            position: absolute;
            top: 0;
            right: 60px;
            width: 1px;
            height: 100%;
            background-color: rgba(242, 235, 225, 0.1);
        }

        /* Sisi Kanan (Form) */
        .vy-split-form {
            flex: 1;
            background-color: var(--vy-cream);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            overflow-y: auto; /* Jika layar kecil, form bisa di-scroll */
        }

        .form-container {
            width: 100%;
            max-width: 420px;
            animation: fadeInUpLuxury 0.8s ease forwards;
        }

        @keyframes fadeInUpLuxury { 
            from { opacity: 0; transform: translateY(30px); } 
            to { opacity: 1; transform: translateY(0); } 
        }

        /* --- HEADER FORM --- */
        .auth-header-editorial { margin-bottom: 40px; }
        
        .badge-serif {
            display: inline-block; 
            font-family: 'Montserrat', sans-serif; 
            font-size: 10px; 
            font-weight: 700; 
            letter-spacing: 0.35em; 
            text-transform: uppercase; 
            color: var(--vy-pine); 
            opacity: 0.6; 
            margin-bottom: 15px;
        }
        
        .editorial-form-title {
            font-family: 'Playfair Display', serif; 
            font-size: 2.2rem; 
            font-weight: 600; 
            color: var(--vy-pine);
            line-height: 1.2;
        }

        /* --- INLINE ALERT (PENGGANTI POP-UP) --- */
        .alert-message-luxury {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            font-family: 'Montserrat', sans-serif;
            font-size: 12px;
            font-weight: 600;
        }
        .alert-error {
            background-color: rgba(194, 89, 83, 0.1);
            color: #C25953;
            border: 1px solid rgba(194, 89, 83, 0.2);
        }
        .alert-success {
            background-color: rgba(26, 47, 36, 0.1);
            color: var(--vy-pine);
            border: 1px solid rgba(26, 47, 36, 0.2);
        }

        /* --- FORM & INPUT --- */
        .form-group-hairline { display: flex; flex-direction: column; gap: 8px; margin-bottom: 35px; }
        
        .form-group-hairline label { 
            font-family: 'Montserrat', sans-serif; 
            font-size: 9px; 
            font-weight: 700; 
            letter-spacing: 0.25em; 
            text-transform: uppercase; 
            color: var(--vy-pine); 
            opacity: 0.8;
        }
        
        .input-hairline { 
            width: 100%; 
            background: transparent; 
            border: none; 
            border-bottom: 1px solid rgba(26, 47, 36, 0.25); 
            padding: 10px 0; 
            font-family: 'Playfair Display', serif; 
            font-size: 18px; 
            color: var(--vy-pine); 
            outline: none; 
            transition: 0.4s; 
        }
        
        .input-hairline::placeholder { 
            color: rgba(26, 47, 36, 0.35); 
            font-size: 14px; 
            font-family: 'Montserrat', sans-serif; 
        }
        
        .input-hairline:focus { border-bottom-color: var(--vy-pine); }
        .error-message-inline { font-family: 'Montserrat', sans-serif; font-size: 10px; color: #C25953; font-weight: 600; margin-top: 5px; }

        /* --- PASSWORD TOGGLE --- */
        .password-wrapper-luxury { position: relative; display: flex; align-items: center; }
        .input-password { padding-right: 40px; }
        .toggle-password-icon { 
            position: absolute; 
            right: 0; 
            bottom: 12px; 
            cursor: pointer; 
            color: rgba(26, 47, 36, 0.4); 
            font-size: 16px; 
            transition: 0.3s; 
        }
        .toggle-password-icon:hover { color: var(--vy-pine); }

        /* --- LINKS --- */
        .auth-options { margin-bottom: 40px; margin-top: -10px; }
        .auth-link-text { font-family: 'Montserrat', sans-serif; font-size: 12px; color: rgba(26, 47, 36, 0.6); }
        
        .auth-link-bold { 
            font-weight: 700; 
            color: var(--vy-pine); 
            text-decoration: none; 
            border-bottom: 1px solid var(--vy-pine); 
            padding-bottom: 2px; 
            transition: 0.3s; 
            margin-left: 5px; 
        }
        .auth-link-bold:hover { opacity: 0.6; }
        
        /* --- BUTTON SOLID PINE --- */
        .btn-checkout-pill {
            background-color: var(--vy-pine);
            color: var(--vy-cream);
            padding: 18px 45px;
            border-radius: 40px;
            border: none;
            width: 100%;
            font-family: 'Montserrat', sans-serif;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            cursor: pointer;
            transition: 0.4s;
            display: flex;
            justify-content: space-between; /* Arrow ke kanan */
            align-items: center;
            padding-left: 30px;
            padding-right: 30px;
        }

        .btn-checkout-pill:hover {
            background-color: transparent;
            color: var(--vy-pine);
            box-shadow: inset 0 0 0 1.5px var(--vy-pine);
            transform: translateY(-3px);
        }

        /* --- RESPONSIVE MOBILE --- */
        @media (max-width: 900px) {
            body { overflow: auto; }
            .vy-split-layout { flex-direction: column; height: auto; min-height: 100vh; }
            .vy-split-brand { padding: 40px 20px; text-align: center; flex: none; min-height: 40vh; }
            .brand-headline { font-size: 3rem; }
            .brand-decorative-line { display: none; }
            .vy-split-form { padding: 40px 20px; align-items: flex-start; }
            .form-container { margin-top: 20px; }
        }
    </style>
</body>
</html>