<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vybrasi - Buat Akun Baru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
</head>
<body>

    <div class="vy-split-layout">
        {{-- SISI KIRI: BRANDING (PINE) --}}
        <div class="vy-split-brand">
            <div class="brand-content-wrapper">
                <div class="brand-logo-text">Vybrasi.</div>
                <h1 class="brand-headline">Mari<br><i class="serif-accent">Bergabung.</i></h1>
                <p class="brand-description">Daftarkan diri Anda untuk mendapatkan akses eksklusif ke koleksi kurasi kopi terbaik kami.</p>
            </div>
        </div>

        {{-- SISI KANAN: FORM (CREAM) --}}
        <div class="vy-split-form">
            <div class="form-container">
                <div class="auth-header-editorial">
                    <span class="badge-serif">Registrasi</span>
                    <h2 class="editorial-form-title">Buat Akun Baru</h2>
                </div>

                <form action="{{ route('daftar.proses') }}" method="POST" class="auth-form">
                    @csrf
                    
                    <div class="form-group-hairline">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="input-hairline" placeholder="Nama Anda" value="{{ old('name') }}" required>
                        @error('name') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group-hairline">
                        <label for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" class="input-hairline" placeholder="contoh@gmail.com" value="{{ old('email') }}" required>
                        @error('email') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group-hairline">
                        <label for="password">Kata Sandi</label>
                        <input type="password" name="password" id="password" class="input-hairline" placeholder="Minimal 8 karakter" required>
                        @error('password') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group-hairline">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="input-hairline" placeholder="Ulangi kata sandi" required>
                    </div>

                    <div class="auth-options">
                        <span class="auth-link-text">Sudah punya akun? <a href="{{ route('login') }}" class="auth-link-bold">Masuk</a></span>
                    </div>

                    <button type="submit" class="btn-checkout-pill auth-btn-full">
                        Daftar Sekarang <i class="fa-solid fa-arrow-right-long" style="margin-left: 8px;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --vy-cream: #F2EBE1; --vy-pine: #1A2F24; }
        body { font-family: 'Montserrat', sans-serif; background-color: var(--vy-cream); color: var(--vy-pine); }

        .vy-split-layout { display: flex; width: 100%; height: 100vh; }

        /* Sisi Kiri */
        .vy-split-brand { flex: 1; background-color: var(--vy-pine); color: var(--vy-cream); padding: 60px; display: flex; align-items: center; justify-content: center; }
        .brand-headline { font-family: 'Playfair Display', serif; font-size: 4rem; line-height: 1.1; margin-bottom: 20px; }
        .serif-accent { font-style: italic; font-weight: 500; }
        .brand-description { opacity: 0.7; font-size: 14px; max-width: 400px; line-height: 1.6; }

        /* Sisi Kanan */
        .vy-split-form { flex: 1; background-color: var(--vy-cream); display: flex; justify-content: center; align-items: center; padding: 40px; }
        .form-container { width: 100%; max-width: 420px; }

        /* Form UI */
        .badge-serif { font-size: 10px; font-weight: 700; letter-spacing: 0.35em; text-transform: uppercase; color: var(--vy-pine); opacity: 0.6; margin-bottom: 15px; display: block; }
        .editorial-form-title { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: var(--vy-pine); margin-bottom: 30px; }
        
        .form-group-hairline { margin-bottom: 25px; }
        .form-group-hairline label { font-size: 9px; font-weight: 700; letter-spacing: 0.25em; text-transform: uppercase; color: var(--vy-pine); opacity: 0.8; margin-bottom: 8px; display: block; }
        .input-hairline { width: 100%; background: transparent; border: none; border-bottom: 1px solid rgba(26, 47, 36, 0.25); padding: 10px 0; font-family: 'Playfair Display', serif; font-size: 18px; color: var(--vy-pine); outline: none; transition: 0.4s; }
        .input-hairline:focus { border-bottom-color: var(--vy-pine); }

        .error-message { color: #C25953; font-size: 10px; font-weight: 600; margin-top: 5px; display: block; }

        .auth-link-bold { font-weight: 700; color: var(--vy-pine); text-decoration: none; border-bottom: 1px solid var(--vy-pine); transition: 0.3s; }
        .auth-link-bold:hover { opacity: 0.6; }

        .btn-checkout-pill { background-color: var(--vy-pine); color: var(--vy-cream); padding: 18px 45px; border-radius: 40px; border: none; width: 100%; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.2em; cursor: pointer; transition: 0.4s; }
        .btn-checkout-pill:hover { background-color: transparent; color: var(--vy-pine); box-shadow: inset 0 0 0 1.5px var(--vy-pine); }

        @media (max-width: 900px) {
            .vy-split-layout { flex-direction: column; height: auto; }
            .vy-split-brand { padding: 40px; min-height: 30vh; }
        }
    </style>
</body>
</html>