<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vybrasi - Login</title>
    <link rel="stylesheet" href="{{ asset('css-admin/daftar.css') }}">
</head>
<body>
    <div class="register-container">
        
        <div class="hero-section">
            <h1 class="hero-text">Mulai<br>Perjalanan<br>Kopimu</h1>
        </div>

        <div class="form-section">
            <div class="register-box">
                <h2>Login</h2>
                
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukan email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukan password" required>
                    </div>

                    <div class="auth-link-container">
                        <span class="auth-link-text">Belum punya akun? <a href="{{ route('daftar') }}">Daftar</a></span>
                    </div>

                    <button type="submit" class="btn-register">Login</button>
                </form>
                
            </div>
        </div>

    </div>
</body>
</html>