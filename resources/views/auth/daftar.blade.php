<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vybrasi - Mulai Perjalanan Kopimu (Daftar)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('daftar.css') }}">
</head>
<body>
    <div class="register-container">
        
        <div class="hero-section">
            <h1 class="hero-text">Mulai<br>Perjalanan<br>Kopimu</h1>
        </div>

        <div class="form-section">
            <div class="register-box">
                <h2>Daftar</h2>
                
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukan nama" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukan email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukan password" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm-password">Konfirmasi password</label>
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="konfirmasi password" required>
                    </div>

                    <div class="auth-link-container">
                        <span class="auth-link-text">Sudah punya akun? <a href="{{ route('login') }}">Login</a></span>
                    </div>

                    <button type="submit" class="btn-register">Daftar</button>
                </form>
                
            </div>
        </div>

    </div>
</body>
</html>