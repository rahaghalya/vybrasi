@extends('layouts.admin')
@section('title', 'Manajemen Produk')

@section('content')
<h2 class="main-title">Daftar Produk Kopi</h2>

<div class="product-toolbar">
    <div class="toolbar-left">
        <div class="toolbar-group">
            <label>Cari Produk</label>
            <div class="search-input-wrapper">
                <input type="text" placeholder="Cari Produk...">
                <button type="button" class="btn-search"><i class="fas fa-search"></i></button>
            </div>
        </div>
        
        <div class="toolbar-group">
            <label>Filter</label>
            <div class="select-wrapper">
                <select>
                    <option value="">Kategori</option>
                    <option value="biji">Biji Kopi</option>
                    <option value="bubuk">Kopi Bubuk</option>
                </select>
            </div>
        </div>

        <div class="toolbar-group">
            <label>Status Stok</label>
            <button type="button" class="btn-filter-stock" id="btnLowStock" onclick="toggleLowStock()">
                <i class="fas fa-exclamation-triangle"></i> Stok Menipis
            </button>
        </div>
    </div>
    
    <div class="toolbar-right">
        <a href="{{ route('admin.produk.tambah') }}" class="btn-add-product" style="text-decoration: none;">
            <i class="fas fa-plus"></i> TAMBAH PRODUK BARU
        </a>
    </div>
</div>

<div class="product-grid-layout" id="productGrid">
    
    @for ($i = 0; $i < 4; $i++)
    <div class="product-list-card" data-stock="{{ $i == 1 ? 3 : 250 }}">
        
        <div class="product-img-box">
            <img src="{{ asset('images/kopi-1.jpg') }}" alt="Kopi Arabica">
        </div>
        
        <div class="product-details">
            <h4 class="product-name">Kopi Arabica 250g {{ $i + 1 }}</h4>
            <p class="product-price">IDR 130.000</p>
            
            <p class="product-stock {{ $i == 1 ? 'text-danger' : '' }}">
                <i class="fas {{ $i == 1 ? 'fa-exclamation-circle' : 'fa-box' }}"></i> 
                Stok: {{ $i == 1 ? 3 : 250 }}
            </p>
            
            <div class="product-actions">
                <span class="action-title">Aksi</span>
                <div class="action-buttons">
                    <a href="{{ route('admin.produk.edit', 1) }}" class="btn-action edit" style="text-decoration: none;">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn-action delete" onclick="openDeleteModal()">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
        
    </div>
    @endfor

</div>

<div class="product-footer">
    <div class="pagination-box">
        <a href="#" class="page-btn">Prev</a>
        <a href="#" class="page-btn active">1</a>
        <a href="#" class="page-btn">2</a>
        <a href="#" class="page-btn">3</a>
        <a href="#" class="page-btn">4</a>
        <a href="#" class="page-btn">Next</a>
    </div>
    <div class="total-products">
        Total: 30 Produk Terdaftar
    </div>
</div>

<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 class="modal-title">Hapus Produk?</h3>
        <p class="modal-text">Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan dan data akan hilang permanen.</p>
        
        <div class="modal-actions">
            <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">Batal</button>
            
            <form action="#" method="POST" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modal-delete"><i class="fas fa-trash-alt"></i> Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>


<script>
    // =========================================================
    // 1. LOGIKA MODAL POP-UP HAPUS
    // =========================================================
    function openDeleteModal() {
        document.getElementById('deleteModal').classList.add('show');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('show');
    }

    // Tutup pop-up jika admin mengklik area gelap di luarnya
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if(e.target === this) {
            closeDeleteModal();
        }
    });

    // =========================================================
    // 2. LOGIKA FILTER STOK MENIPIS (MANUAL & OTOMATIS)
    // =========================================================
    let isLowStockFilterActive = false;

    function toggleLowStock() {
        isLowStockFilterActive = !isLowStockFilterActive; // Toggle On/Off status
        const btn = document.getElementById('btnLowStock');
        const cards = document.querySelectorAll('.product-list-card');

        if (isLowStockFilterActive) {
            // MODE ON: Tombol berubah jadi merah
            btn.classList.add('active-filter');
            btn.innerHTML = '<i class="fas fa-times"></i> Batalkan Filter';
            
            // Periksa setiap kartu produk
            cards.forEach(card => {
                const stock = parseInt(card.getAttribute('data-stock'));
                // Sembunyikan jika stok lebih dari 5
                if (stock <= 5) {
                    card.style.display = ''; // Tetap tampilkan sesuai CSS asli
                } else {
                    card.style.display = 'none'; // Sembunyikan
                }
            });
        } else {
            // MODE OFF: Kembalikan tombol seperti semula
            btn.classList.remove('active-filter');
            btn.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Stok Menipis (<= 5)';
            
            // Tampilkan semua kartu kembali
            cards.forEach(card => {
                card.style.display = ''; 
            });
        }
    }

    // =========================================================
    // 3. DETEKSI PARAMETER URL DARI HALAMAN BERANDA
    // =========================================================
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil parameter dari URL (misal: ?filter=low_stock)
        const urlParams = new URLSearchParams(window.location.search);
        const filterParam = urlParams.get('filter');

        // Jika parameter filter adalah 'low_stock', jalankan fungsi filter otomatis
        if (filterParam === 'low_stock') {
            // Pastikan fungsi toggleLowStock dipanggil setelah semua elemen siap
            setTimeout(() => {
                toggleLowStock();
            }, 100); 
        }
    });
</script>
@endsection