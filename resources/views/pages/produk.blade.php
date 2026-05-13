@extends('layouts.app')

@section('title', 'Vybrasi - Daftar Produk')

@section('content')
<form action="{{ route('produk') }}" method="GET" class="page-produk-container" id="filter-form">
    
    <aside class="sidebar-filter">
        <h2>Filter</h2>
        
        <div class="filter-group">
            <div class="filter-header">
                <h3>Kategori</h3>
                <span>v</span>
            </div>
            
            {{-- PERBAIKAN: Menggunakan type="radio" dan name yang sama agar saling menggantikan --}}
            <label class="custom-checkbox">
                <input type="radio" name="kategori" value="" onchange="this.form.submit()" {{ empty(request('kategori')) ? 'checked' : '' }}>
                <span class="checkmark" style="border-radius: 50%;"></span>
                Semua
            </label>

            <label class="custom-checkbox">
                <input type="radio" name="kategori" value="gula_aren" onchange="this.form.submit()" {{ request('kategori') == 'gula_aren' ? 'checked' : '' }}>
                <span class="checkmark" style="border-radius: 50%;"></span>
                Gula Aren
            </label>

            <label class="custom-checkbox">
                <input type="radio" name="kategori" value="signature" onchange="this.form.submit()" {{ request('kategori') == 'signature' ? 'checked' : '' }}>
                <span class="checkmark" style="border-radius: 50%;"></span>
                Signature Series
            </label>

            <label class="custom-checkbox">
                <input type="radio" name="kategori" value="unggulan" onchange="this.form.submit()" {{ request('kategori') == 'unggulan' ? 'checked' : '' }}>
                <span class="checkmark" style="border-radius: 50%;"></span>
                Produk Unggulan
            </label>
        </div>

        <hr class="filter-divider">

        <div class="filter-group">
            <div class="filter-header">
                <h3>Stok</h3>
                <span>v</span>
            </div>
            <label class="custom-checkbox">
                <input type="radio" name="stok" value="tersedia" onchange="this.form.submit()" {{ request('stok', 'tersedia') == 'tersedia' ? 'checked' : '' }}>
                <span class="checkmark" style="border-radius: 50%;"></span>
                Tersedia
            </label>
            <label class="custom-checkbox">
                <input type="radio" name="stok" value="habis" onchange="this.form.submit()" {{ request('stok') == 'habis' ? 'checked' : '' }}>
                <span class="checkmark" style="border-radius: 50%;"></span>
                Habis
            </label>
        </div>
    </aside>

    <main class="main-produk">
        
        <div class="produk-header-row">
            <h1>Daftar Produk</h1>
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass" style="cursor: pointer;" onclick="document.getElementById('filter-form').submit();"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="cari produk..." onkeypress="if(event.key === 'Enter') this.form.submit();">
            </div>
        </div>

        <div class="daftar-produk-grid">
            @forelse ($produks as $item)
            <div class="produk-card-item">
                <div class="produk-img-wrapper">
                    <a href="{{ route('produk.detail', ['slug' => $item->slug ?? 'default']) }}" style="display: block; height: 100%;">
                        <img src="{{ $item->gambar_utama ? $item->gambar_utama : 'https://placehold.co/400x350/5a3c2a/FFF?text=' . urlencode($item->nama) }}" 
                             alt="{{ $item->nama }}" 
                             style="transition: transform 0.3s; width: 100%; height: 100%; object-fit: cover;" 
                             onmouseover="this.style.transform='scale(1.05)'" 
                             onmouseout="this.style.transform='scale(1)'">
                    </a>
                </div>
                <div class="produk-detail">
                    <h3>
                        <a href="{{ route('produk.detail', ['slug' => $item->slug ?? 'default']) }}" style="color: inherit; text-decoration: none;">
                            {{ $item->nama }}
                        </a>
                    </h3>
                    <p style="color: #D4A373; font-weight: bold; margin: 5px 0 10px 0;">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </p>

                    <div class="produk-action" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        
                        <div style="display: flex; gap: 8px;">
                            <button type="submit" form="form-cart-{{ $item->id_produk }}" class="btn-order" style="background: transparent; color: #D4A373; border: 1px solid #D4A373; padding: 5px 10px; cursor: pointer;" title="Tambah ke Keranjang">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                            
                            <a href="{{ route('produk.detail', ['slug' => $item->slug ?? 'default']) }}">
                                <button type="button" class="btn-order">Detail</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: span 3; text-align: center; padding: 50px;">
                <i class="fa-solid fa-box-open" style="font-size: 40px; color: #ccc; margin-bottom: 15px;"></i>
                <h3 style="color: #666;">Produk tidak ditemukan.</h3>
                <p style="color: #999; font-size: 14px;">Coba gunakan kata kunci pencarian atau filter yang lain.</p>
            </div>
            @endforelse
        </div>

        @if ($produks->hasPages())
        <div class="pagination">
            @if ($produks->onFirstPage())
                <span class="page-nav" style="opacity: 0.5; cursor: not-allowed;">&lt;</span>
            @else
                <a href="{{ $produks->previousPageUrl() }}" class="page-nav">&lt;</a>
            @endif

            @foreach ($produks->getUrlRange(1, $produks->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="page-num" style="{{ $page == $produks->currentPage() ? 'background-color: #D4A373; color: white;' : '' }}">
                    {{ $page }}
                </a>
            @endforeach

            @if ($produks->hasMorePages())
                <a href="{{ $produks->nextPageUrl() }}" class="page-nav">&gt;</a>
            @else
                <span class="page-nav" style="opacity: 0.5; cursor: not-allowed;">&gt;</span>
            @endif
        </div>
        @endif
        
    </main>
</form>

@foreach ($produks as $item)
<form id="form-cart-{{ $item->id_produk }}" action="{{ route('keranjang.tambah') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="id_produk" value="{{ $item->id_produk }}">
    <input type="hidden" name="jumlah" value="1">
</form>
@endforeach
@endsection