<nav class="navbar">
<<<<<<< HEAD
    <div class="logo">
        <a href="{{ route('beranda') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Vybrasi Logo">
        </a>
    </div>

    <ul class="nav-links">
        <li><a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">BERANDA</a></li>
        <li><a href="{{ route('produk') }}" class="{{ request()->routeIs('produk') ? 'active' : '' }}">PRODUK</a></li>
        <li><a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">TENTANG</a></li>
        <li><a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">KONTAK</a></li>
        
        {{-- Menu PROFIL dan KERANJANG hanya muncul kalau user sudah login --}}
        @auth
            <li><a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}">PROFIL</a></li>
            <li>
                <a href="{{ route('keranjang.index') }}" class="{{ request()->routeIs('keranjang.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-cart-shopping" style="margin-right: 5px;"></i> KERANJANG
                </a>
            </li>
        @endauth
    </ul>

    <div class="auth-buttons">
        {{-- @guest berarti: Jika user BELUM login, tampilkan tombol Daftar & Login --}}
        @guest
            <a href="{{ route('daftar') }}" class="btn-outline">DAFTAR</a>
            <a href="{{ route('login') }}" class="btn-outline btn-login">LOG IN</a>
        @endguest

        {{-- @auth berarti: Jika user SUDAH login, tampilkan tombol Log Out --}}
        @auth
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-outline btn-login" style="cursor: pointer;">LOG OUT</button>
            </form>
        @endauth
    </div>
</nav>
=======

    {{-- =========================================
         KIRI: Hamburger Menu & Logo
         ========================================= --}}
    <div class="nav-left">
        {{-- Hamburger Menu (Hanya tampil di Mobile/Tablet) --}}
        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        {{-- Logo Vybrasi --}}
        <div class="logo">
            <a href="{{ route('beranda') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Vybrasi Logo">
            </a>
        </div>
    </div>

    {{-- =========================================
         TENGAH: Navigasi (Menjadi Dropdown di Mobile)
         ========================================= --}}
    <ul class="nav-links" id="navMenu">
        <li>
            <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a>
        </li>
        <li>
            <a href="{{ route('produk') }}" class="{{ request()->routeIs('produk') ? 'active' : '' }}">Katalog</a>
        </li>
        <li>
            <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang</a>
        </li>
        <li>
            <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a>
        </li>
        
        @auth
        <li>
            <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}">Profil</a>
        </li>
        @endauth
    </ul>

    {{-- =========================================
         KANAN: Tombol Auth & Keranjang
         ========================================= --}}
    <div class="nav-right">
        
        {{-- Kondisi: Belum Login --}}
        @guest
            <a href="{{ route('login') }}" class="btn-login">Login</a>
            <a href="{{ route('daftar') }}" class="btn-outline">Daftar</a>
        @endguest

        {{-- Kondisi: Sudah Login --}}
        @auth
            <a href="{{ route('keranjang.index') }}" class="cart-btn" aria-label="Keranjang">
                <i class="fa-solid fa-bag-shopping"></i>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="btn-outline">Logout</button>
            </form>
        @endauth
        
    </div>

</nav>

{{-- =========================================
     SCRIPT: Logika Dropdown Menu Mobile
     ========================================= --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburgerBtn");
    const navMenu = document.getElementById("navMenu");

    if (hamburger && navMenu) {
        hamburger.addEventListener("click", function () {
            navMenu.classList.toggle("active");
            hamburger.classList.toggle("active");
        });
    }
});
</script>
>>>>>>> frontend-ui
