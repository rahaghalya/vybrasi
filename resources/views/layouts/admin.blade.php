<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Vybrasi</title>
    <link rel="stylesheet" href="{{ asset('css-admin/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* --- KUNCI UTAMA: LAYOUT FLEXBOX --- */
        .admin-container {
            display: flex;
            align-items: flex-start; /* Wajib agar elemen Sticky berfungsi */
            min-height: 100vh;
            width: 100%;
            background: #0a0a0a;
        }

        /* --- SIDEBAR (STICKY: DIAM DI TEMPAT) --- */
        .sidebar {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: #0d0d0d !important; /* Paksa warna hitam pekat */
            z-index: 999;
            flex-shrink: 0; /* Cegah sidebar menciut */
            transition: transform 0.3s ease;
        }

        /* --- KONTEN UTAMA --- */
        .main-content {
            flex: 1; /* Ambil sisa ruang layar secara otomatis */
            min-width: 0; /* Wajib! Mencegah tabel panjang merusak layout */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .brand {
            flex-shrink: 0;
            padding: 25px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* AREA SCROLL DENGAN ID KHUSUS UNTUK MEMORI */
        #sidebar-scroll-area {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 80px;
            scrollbar-width: none; 
            -ms-overflow-style: none;
        }
        #sidebar-scroll-area::-webkit-scrollbar { display: none; }

        /* --- STYLING NAVIGASI --- */
        .nav-menu { display: flex; flex-direction: column; margin-top: 10px; }
        .nav-item { 
            padding: 12px 25px; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            color: #aaa; 
            text-decoration: none; 
            transition: .2s; 
            position: relative;
        }
        .nav-item:hover, .nav-item.active { color: #fff; background: rgba(212, 163, 115, 0.05); }
        .nav-item.active { border-left: 3px solid #D4A373; color: #D4A373; }
        .nav-item i { width: 20px; font-size: 16px; text-align: center; }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 15px 0;
        }

        .sidebar-profile {
            padding: 20px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 10px;
        }
        .avatar-circle { width: 45px; height: 45px; border-radius: 50%; background: #f4f6f9; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; }
        .profile-name { color: #ffffff; font-size: 15px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .profile-role { color: #D4A373; font-size: 12px; margin-top: 3px; }

        /* --- DROPDOWN SYSTEM --- */
        .dropdown-wrapper { display: flex; flex-direction: column; }
        .dropdown-btn { cursor: pointer; justify-content: space-between !important; }
        .dropdown-container { 
            display: none; 
            background: #0a0a0a; 
            padding-left: 15px; 
            border-left: 1px dashed #222;
            margin-left: 35px;
            margin-bottom: 10px;
        }
        .dropdown-container.show { display: block; }
        .dropdown-item { 
            padding: 10px 20px; 
            font-size: 13px; 
            display: block; 
            color: #777; 
            text-decoration: none; 
            transition: .2s;
        }
        .dropdown-item:hover, .dropdown-item.active { color: #D4A373; }
        .arrow-icon { font-size: 10px !important; transition: transform 0.3s; }
        .dropdown-btn.open .arrow-icon { transform: rotate(180deg); }

        /* --- SIHIR CSS RESPONSIVE KHUSUS MOBILE --- */
        .mobile-header-actions { display: none; align-items: center; gap: 15px; margin-right: 15px;}
        .btn-hamburger {
            background: transparent;
            border: none;
            color: #D4A373;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(3px);
            z-index: 9998;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .top-header { display: flex; align-items: center; padding: 20px 28px; border-bottom: 1px solid rgba(255,255,255,0.02);}

        @media (max-width: 768px) {
            /* Sembunyikan sidebar ke kiri luar layar */
            .sidebar {
                position: fixed; /* Berubah jadi melayang khusus di HP */
                width: 280px;
                transform: translateX(-100%);
            }
            .sidebar.mobile-open {
                transform: translateX(0);
                box-shadow: 5px 0 25px rgba(0,0,0,0.8);
            }
            .sidebar-overlay.mobile-open {
                display: block;
                opacity: 1;
            }
            .mobile-header-actions {
                display: flex;
            }
            .top-header { padding: 15px 15px 0 15px; border-bottom: none; }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        
        {{-- LAYAR GELAP TRANSPARAN UNTUK MOBILE --}}
        <div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleMobileSidebar()"></div>

        <aside class="sidebar" id="main-sidebar">
            {{-- LOGO DIPERBESAR --}}
            <div class="brand">
                <img src="{{ asset('images/logo.png') }}" alt="VYBRASI" style="max-height: 75px; width: auto; object-fit: contain;">
            </div>

            <div id="sidebar-scroll-area">
                <div class="sidebar-profile">
                    <div class="avatar-circle">
                        @if(auth()->check() && auth()->user()->avatar_url)
                            <img src="{{ asset('storage/' . auth()->user()->avatar_url) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-user" style="color: #C25953; font-size: 20px;"></i>
                        @endif
                    </div>
                    <div class="profile-info">
                        <span class="profile-name">{{ auth()->check() ? auth()->user()->full_name : 'Admin Vybrasi' }}</span>
                        <span class="profile-role">Administrator</span>
                    </div>
                </div>

                <nav class="nav-menu">
                    <a href="{{ route('admin.beranda') }}" class="nav-item {{ request()->routeIs('admin.beranda') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                    
                    <a href="{{ route('admin.pesanan_baru') }}" class="nav-item {{ request()->routeIs('admin.pesanan_baru') ? 'active' : '' }}">
                       <i class="fas fa-cart-plus"></i> Pesanan Baru (KDS)
                       @php $pc = \Illuminate\Support\Facades\DB::table('jualan_kopi.transaksi')->where('status', 'pending')->count(); @endphp
                       @if($pc > 0) <span class="nav-badge" style="background:#D4A373; color:#000; font-size:10px; padding:2px 6px; border-radius:50px; margin-left:auto;">{{ $pc }}</span> @endif
                    </a>

                    <a href="{{ route('admin.produk') }}" class="nav-item {{ request()->routeIs('admin.produk') ? 'active' : '' }}">
                        <i class="fas fa-box"></i> Manajemen Produk
                    </a>

                    <a href="{{ route('admin.affiliate') }}" class="nav-item {{ request()->routeIs('admin.affiliate') ? 'active' : '' }}">
                       <i class="fas fa-users"></i> Manajemen Affiliate
                    </a>
                    
                    <a href="{{ route('admin.laporan') }}" class="nav-item {{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                       <i class="fas fa-list-alt"></i> Laporan Transaksi
                    </a>

                    <a href="{{ route('admin.pengiriman') }}" class="nav-item {{ request()->routeIs('admin.pengiriman') ? 'active' : '' }}">
                       <i class="fas fa-shipping-fast"></i> Pengiriman
                    </a>

                    <div class="dropdown-wrapper">
                        <div class="nav-item dropdown-btn" onclick="toggleDropdown('cms-drop')">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <i class="fas fa-laptop-code"></i> Kelola Web
                            </div>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </div>
                        <div class="dropdown-container" id="cms-drop">
                            <a href="{{ route('admin.konten.beranda') }}" class="dropdown-item {{ request()->routeIs('admin.konten.beranda') ? 'active' : '' }}">Beranda & Banner</a>
                            <a href="{{ route('admin.konten.tentang') }}" class="dropdown-item {{ request()->routeIs('admin.konten.tentang') ? 'active' : '' }}">Tentang Kami</a>
                            <a href="{{ route('admin.konten.kontak') }}" class="dropdown-item {{ request()->routeIs('admin.konten.kontak') ? 'active' : '' }}">Kontak & Sosmed</a>
                        </div>
                    </div>

                    <a href="{{ route('admin.pesan') }}" class="nav-item {{ request()->routeIs('admin.pesan') ? 'active' : '' }}">
                        <i class="fas fa-comment-dots"></i> Pesan & Ulasan
                        <span class="nav-badge" id="sidebar-pesan-badge" style="display: none;">0</span>
                    </a>

                    <div class="sidebar-divider"></div>

                    <a href="#" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #ff6b6b;">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </nav>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-header">
                {{-- TOMBOL HAMBURGER MUNCUL DI SINI SAAT DI HP --}}
                <div class="mobile-header-actions">
                    <button class="btn-hamburger" onclick="toggleMobileSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <h2 style="margin: 0;">@yield('title')</h2>
            </header>

            <section class="content-body">
                @yield('content')
            </section>
        </main>
    </div>

    <script>
        function toggleMobileSidebar() {
            document.getElementById('main-sidebar').classList.toggle('mobile-open');
            document.getElementById('sidebar-overlay').classList.toggle('mobile-open');
        }

        function toggleDropdown(id) {
            const drop = document.getElementById(id);
            const btn = drop.previousElementSibling;
            drop.classList.toggle('show');
            btn.classList.toggle('open');
            localStorage.setItem(id, drop.classList.contains('show'));
        }

        window.addEventListener('load', () => {
            if (localStorage.getItem('cms-drop') === 'true') {
                const drop = document.getElementById('cms-drop');
                drop.classList.add('show');
                drop.previousElementSibling.classList.add('open');
            }
        });

        const scrollArea = document.getElementById('sidebar-scroll-area');
        scrollArea.addEventListener('scroll', () => {
            localStorage.setItem('sidebar_scroll_pos', scrollArea.scrollTop);
        });

        document.addEventListener("DOMContentLoaded", function() {
            const savedPos = localStorage.getItem('sidebar_scroll_pos');
            if (savedPos) {
                scrollArea.scrollTop = savedPos;
            }

            let unreadCount = localStorage.getItem('vyb_unread_count');
            let badge = document.getElementById('sidebar-pesan-badge');
            if (badge && unreadCount && parseInt(unreadCount) > 0) {
                badge.innerText = unreadCount;
                badge.style.display = 'inline-block';
            }
        });
    </script>
</body>
</html>