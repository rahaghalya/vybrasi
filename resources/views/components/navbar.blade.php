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