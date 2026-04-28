@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')

<a href="{{ route('admin.produk') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk
</a>

<h2 class="main-title">Tambah Produk Baru</h2>

<div class="form-card">
    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        
        <h3 class="form-section-title">Informasi Dasar</h3>
        <div class="form-grid">
            <div class="form-group full-width">
                <label>Nama Produk</label>
                <input type="text" class="premium-input" placeholder="Masukkan nama produk (ex: Kopi Arabica Gayo)">
            </div>

            <div class="form-group">
                <label>Kategori Produk</label>
                <select class="premium-select">
                    <option value="">Pilih Kategori</option>
                    <option value="biji">Biji Kopi (Roasted Beans)</option>
                    <option value="bubuk">Kopi Bubuk (Ground Coffee)</option>
                    <option value="drip">Drip Bag Coffee</option>
                </select>
            </div>

            <div class="form-group">
                <label>Harga Produk (Rp)</label>
                <input type="number" class="premium-input" placeholder="Contoh: 150000">
            </div>

            <div class="form-group">
                <label>Stok Awal</label>
                <input type="number" class="premium-input" placeholder="Contoh: 50">
            </div>

            <div class="form-group">
                <label>Berat Bersih (Gram)</label>
                <input type="number" class="premium-input" placeholder="Contoh: 250">
            </div>

            <div class="form-group full-width">
                <label>Deskripsi Produk</label>
                <textarea class="premium-textarea" placeholder="Tuliskan deskripsi rasa, asal kopi, dan catatan lainnya..."></textarea>
            </div>
        </div>

        <h3 class="form-section-title" style="margin-top: 20px;">Media Produk</h3>
        <div class="form-group full-width">
            <label>Foto Produk</label>
            <div class="upload-area">
                <input type="file" class="file-input-hidden" accept="image/png, image/jpeg, image/jpg">
                <div class="upload-icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div class="upload-text">Klik atau Tarik gambar ke area ini</div>
                <div class="upload-subtext">Format yang didukung: JPG, JPEG, PNG (Maks. 2MB)</div>
            </div>
        </div>

        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('admin.produk') }}'">Batal</button>
            <button type="submit" class="btn-save"><i class="fas fa-save"></i> Simpan Produk</button>
        </div>

    </form>
</div>

@endsection