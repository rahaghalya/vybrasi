<nav class="navbar">
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
        <li><a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}">PROFIL</a></li>
    </ul>

    <div class="auth-buttons">
        <a href="#" class="btn-outline">DAFTAR</a>
        <a href="#" class="btn-outline btn-login">LOG IN</a>
    </div>
</nav>