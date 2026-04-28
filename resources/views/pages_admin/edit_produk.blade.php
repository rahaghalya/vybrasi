@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')

<a href="{{ route('admin.produk') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk
</a>

<h2 class="main-title">Edit Data Produk</h2>

<div class="form-card">
    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        
        <h3 class="form-section-title">Informasi Dasar</h3>
        <div class="form-grid">
            <div class="form-group full-width">
                <label>Nama Produk</label>
                <input type="text" class="premium-input" value="Kopi Arabica Gayo" placeholder="Masukkan nama produk">
            </div>

            <div class="form-group">
                <label>Kategori Produk</label>
                <select class="premium-select">
                    <option value="biji" selected>Biji Kopi (Roasted Beans)</option>
                    <option value="bubuk">Kopi Bubuk (Ground Coffee)</option>
                    <option value="drip">Drip Bag Coffee</option>
                </select>
            </div>

            <div class="form-group">
                <label>Harga Produk (Rp)</label>
                <input type="number" class="premium-input" value="85000" placeholder="Contoh: 150000">
            </div>

            <div class="form-group">
                <label>Stok Saat Ini</label>
                <input type="number" class="premium-input" value="24" placeholder="Contoh: 50">
            </div>

            <div class="form-group">
                <label>Berat Bersih (Gram)</label>
                <input type="number" class="premium-input" value="250" placeholder="Contoh: 250">
            </div>

            <div class="form-group full-width">
                <label>Deskripsi Produk</label>
                <textarea class="premium-textarea">Biji kopi pilihan dengan notes rasa cokelat hitam, rempah halus, dan tingkat keasaman yang rendah. Cocok untuk espresso harian Anda.</textarea>
            </div>
        </div>

        <h3 class="form-section-title" style="margin-top: 20px;">Media Produk</h3>
        <div class="form-group full-width">
            
            <div class="current-image-preview">
                <img src="https://via.placeholder.com/80" alt="Foto Saat Ini">
                <div class="current-image-info">
                    <span>Foto Saat Ini</span>
                    <small>arabica-gayo.jpg</small>
                </div>
            </div>

            <label>Ganti Foto Produk (Opsional)</label>
            <div class="upload-area">
                <input type="file" class="file-input-hidden" accept="image/png, image/jpeg, image/jpg">
                <div class="upload-icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div class="upload-text">Klik atau Tarik gambar ke area ini jika ingin mengganti foto</div>
                <div class="upload-subtext">Biarkan kosong jika tidak ingin mengganti foto. Format: JPG, PNG (Maks. 2MB)</div>
            </div>
        </div>

        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('admin.produk') }}'">Batal</button>
            <button type="submit" class="btn-save"><i class="fas fa-save"></i> Simpan Perubahan</button>
        </div>

    </form>
</div>

@endsection