<nav class="navbar" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 5%; background-color: rgba(249, 246, 240, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid rgba(118, 138, 120, 0.15); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.02);">
    
    {{-- LOGO BRAND (Diperbesar ke 80px agar lebih mantap & proporsional) --}}
    <div class="logo">
        <a href="{{ route('beranda') }}" style="display: block;">
            <img src="{{ asset('images/logo.png') }}" alt="Vybrasi Logo" style="height: 100px; transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);" onmouseover="this.style.transform='scale(1.03)';" onmouseout="this.style.transform='scale(1)';">
        </a>
    </div>

    {{-- MENU NAVIGASI UTAMA (Fokus Bersih untuk Eksplorasi Konten) --}}
    <ul class="nav-links" style="list-style: none; display: flex; align-items: center; gap: 45px; margin: 0; padding: 0;">
        <li><a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">BERANDA</a></li>
        <li><a href="{{ route('produk') }}" class="{{ request()->routeIs('produk') ? 'active' : '' }}">KATALOG</a></li>
        <li><a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">TENTANG</a></li>
        <li><a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">KONTAK</a></li>
        
        @auth
            <li><a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}">PROFIL</a></li>
        @endauth
    </ul>

    {{-- AREA UTILITY & AUTH (POSISI KERANJANG TERBAIK DI SEBELAH KANAN) --}}
    <div class="auth-buttons" style="display: flex; align-items: center; gap: 22px;">
        
        @auth
            {{-- KERANJANG: Dipisah ke kanan, minimalis tanpa teks berlebihan seperti butik high-end --}}
            <a href="{{ route('keranjang.index') }}" class="{{ request()->routeIs('keranjang.index') ? 'active' : '' }}" 
               style="color: #253B2B; text-decoration: none; font-size: 18px; display: flex; align-items: center; position: relative; transition: all 0.3s ease; padding: 5px;" 
               title="Keranjang Belanja"
               onmouseover="this.style.color='#768A78'; this.style.transform='scale(1.08)';" 
               onmouseout="this.style.color='#253B2B'; this.style.transform='scale(1)';">
                <i class="fa-solid fa-bag-shopping"></i>
                
                {{-- Dot Indicator Pendekatan Minimalis jika Halaman Keranjang sedang Aktif --}}
                @if(request()->routeIs('keranjang.index'))
                    <span style="position: absolute; bottom: -2px; left: 50%; transform: translateX(-50%); width: 4px; height: 4px; background-color: #768A78; border-radius: 50%;"></span>
                @endif
            </a>
        @endauth

        {{-- Garis Pemisah Vertikal Tipis dan Elegan --}}
        <div style="width: 1px; height: 20px; background-color: rgba(37, 59, 43, 0.15); margin: 0 4px;"></div>

        @guest
            <a href="{{ route('daftar') }}" class="btn-outline">DAFTAR</a>
            <a href="{{ route('login') }}" class="btn-login" style="padding: 8px 24px; border-radius: 4px;">LOG IN</a>
        @endguest

        @auth
            <form action="{{ route('logout') }}" method="POST" style="display: flex; margin: 0;">
                @csrf
                <button type="submit" class="btn-login" style="padding: 8px 24px; border-radius: 4px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.backgroundColor='#9B4128'; this.style.borderColor='#9B4128';" onmouseout="this.style.backgroundColor='#253B2B'; this.style.borderColor='#253B2B';">LOG OUT</button>
            </form>
        @endauth
    </div>
</nav>