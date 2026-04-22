@extends('layouts.app')

@section('title', 'Vybrasi - Daftar Produk')

@section('content')
<div class="page-produk-container">
    
    <aside class="sidebar-filter">
        <h2>Filter</h2>
        
        <div class="filter-group">
            <div class="filter-header">
                <h3>Kategori</h3>
                <span>v</span>
            </div>
            <label class="custom-checkbox">
                <input type="checkbox" checked>
                <span class="checkmark"></span>
                Semua
            </label>
            <label class="custom-checkbox">
                <input type="checkbox">
                <span class="checkmark"></span>
                Gula Aren
            </label>
            <label class="custom-checkbox">
                <input type="checkbox">
                <span class="checkmark"></span>
                Signature Series
            </label>
            <label class="custom-checkbox">
                <input type="checkbox">
                <span class="checkmark"></span>
                Paket Bundling
            </label>
        </div>

        <hr class="filter-divider">

        <div class="filter-group">
            <div class="filter-header">
                <h3>Stok</h3>
                <span>v</span>
            </div>
            <label class="custom-checkbox">
                <input type="checkbox" checked>
                <span class="checkmark"></span>
                Tersedia
            </label>
            <label class="custom-checkbox">
                <input type="checkbox">
                <span class="checkmark"></span>
                Habis
            </label>
        </div>
    </aside>

    <main class="main-produk">
        
        <div class="produk-header-row">
            <h1>Daftar Produk</h1>
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="cari produk">
            </div>
        </div>

        <div class="daftar-produk-grid">
            @for ($i = 0; $i < 4; $i++)
            <div class="produk-card-item">
                <div class="produk-img-wrapper">
                    <a href="{{ route('produk.detail') }}" style="display: block; height: 100%;">
                        <img src="https://placehold.co/400x350/5a3c2a/FFF?text=Kopi+Arabica" alt="Kopi Arabica" style="transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    </a>
                </div>
                <div class="produk-detail">
                    <h3>
                        <a href="{{ route('produk.detail') }}" style="color: inherit; text-decoration: none;">
                            Kopi Arabica {{ $i == 0 ? '250gr' : ($i == 1 ? '500gr' : ($i == 2 ? '750gr' : '1000gr')) }}
                        </a>
                    </h3>
                    <div class="produk-action">
                        <div class="stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <a href="{{ route('produk.detail') }}">
                            <button class="btn-order">Order</button>
                        </a>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <div class="pagination">
            <a href="#" class="page-nav">&lt;</a>
            <a href="#" class="page-num">1</a>
            <a href="#" class="page-num">2</a>
            <a href="#" class="page-num">3</a>
            <a href="#" class="page-num">4</a>
            <span class="page-dots">...</span>
            <a href="#" class="page-nav">&gt;</a>
        </div>
        
    </main>
</div>
@endsection