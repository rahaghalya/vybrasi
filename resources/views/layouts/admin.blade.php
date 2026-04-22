<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Vybrasi - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="brand">
                <img src="{{ asset('path/to/logo.png') }}" alt="VYBRASI">
            </div>
            <nav class="nav-menu">
                <a href="#" class="nav-item active"><i class="fas fa-home"></i> Beranda</a>
                <a href="#" class="nav-item"><i class="fas fa-box"></i> Manajemen Produk</a>
                <a href="#" class="nav-item"><i class="fas fa-users"></i> Manajemen Affiliate</a>
                <a href="#" class="nav-item"><i class="fas fa-list-alt"></i> Laporan Transaksi</a>
                <a href="#" class="nav-item"><i class="fas fa-shipping-fast"></i> Pengiriman</a>
                <a href="#" class="nav-item"><i class="fas fa-comment-dots"></i> Pesan</a>
                <a href="#" class="nav-item"><i class="fas fa-cart-plus"></i> Pesan Baru</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div class="admin-profile">
                    <div class="avatar-circle">
                        <i class="fas fa-user"></i>
                    </div>
                    <span>Admin Vybrasi</span>
                </div>
            </header>

            <section class="content-body">
                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>