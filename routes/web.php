<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Rute untuk Halaman Beranda
Route::get('/', function () {
    return view('pages.beranda'); 
})->name('beranda');

// Rute untuk Halaman Produk
Route::get('/produk', function () {
    return view('pages.produk'); 
})->name('produk');

// Rute untuk Halaman Detail Produk
Route::get('/produk/detail', function () {
    return view('pages.detail-produk'); 
})->name('produk.detail');

// Rute untuk Halaman Tentang Kami
Route::get('/tentang', function () {
    return view('pages.tentang'); 
})->name('tentang');

// Rute untuk Halaman Kontak
Route::get('/kontak', function () {
    return view('pages.kontak'); 
})->name('kontak');

// Rute untuk Halaman Profil
Route::get('/profil', function () {
    return view('pages.profil'); 
})->name('profil');

// Route untuk membuka halaman form view Profil
Route::get('/view-profil', function () {
    return view('pages.view-profil'); // Pastikan nama ini sesuai dengan nama file blade kamu (tanpa .blade.php)
})->name('profil.view');

// Route untuk membuka halaman form view Profil
Route::get('/edit-profil', function () {
    return view('pages.edit-profil'); // Pastikan nama ini sesuai dengan nama file blade kamu (tanpa .blade.php)
})->name('profil.edit');

// Route untuk halaman Riwayat Pesanan
Route::get('/riwayat-pesanan', function () {
    return view('pages.riwayat-pesanan'); // Pastikan nama file blade-nya riwayat-pesanan.blade.php
})->name('pesanan.riwayat');

// Route untuk halaman Keranjang Saya
Route::get('/keranjang', function () {
    return view('pages.keranjang'); // Pastikan nama file blade-nya keranjang.blade.php
})->name('keranjang.index');

// Route untuk halaman Detail Pemesanan (Checkout)
Route::get('/checkout', function () {
    return view('pages.checkout'); // Buat file checkout.blade.php di dalam folder pages
})->name('checkout');

// Route untuk halaman Metode Pembayaran
Route::get('/metode-pembayaran', function () {
    return view('pages.pembayaran'); // Pastikan nama file blade-nya pembayaran.blade.php
})->name('pembayaran.metode');

// Route untuk halaman Review Pesanan
Route::get('/review-pesanan', function () {
    return view('pages.review-pesanan'); // Pastikan nama file blade-nya review-pesanan.blade.php
})->name('pesanan.review');

// Route untuk halaman Pesanan Berhasil
Route::get('/pesanan-berhasil', function () {
    return view('pages.pesanan-berhasil'); 
})->name('pesanan.berhasil');




//ADMIN ROUTES


// Route untuk Admin Vybrasi (Beranda)
Route::get('/admin/beranda', [AdminController::class, 'index'])->name('admin.beranda');

// Route BARU untuk Admin Vybrasi (Manajemen Produk)
Route::get('/admin/produk', [AdminController::class, 'produk'])->name('admin.produk');

// Route BARU untuk Admin Vybrasi (Manajemen Produk (tambah produk))
Route::get('/admin/produk/tambah', [AdminController::class, 'tambahProduk'])->name('admin.produk.tambah');

// Route BARU untuk Admin Vybrasi (Manajemen Produk (edit produk))
Route::get('/admin/produk/edit/{id?}', [AdminController::class, 'editProduk'])->name('admin.produk.edit');

// ROUTE BARU AFFILIATE
Route::get('/admin/affiliate', [AdminController::class, 'affiliate'])->name('admin.affiliate');

// ROUTE BARU AFFILIATE(tambah affiliate)
Route::get('/admin/affiliate/tambah', [AdminController::class, 'tambahAffiliate'])->name('admin.affiliate.tambah');

// ROUTE BARU AFFILIATE(profil affiliate)
Route::get('/admin/affiliate/profil/{id?}', [AdminController::class, 'profilAffiliate'])->name('admin.affiliate.profil');

// ROUTE BARU LAPORAN TRANSAKSI
Route::get('/admin/laporan-transaksi', [AdminController::class, 'laporanTransaksi'])->name('admin.laporan');

// ROUTE BARU DETAIL TRANSAKSI
Route::get('/admin/transaksi/detail/{id?}', [AdminController::class, 'detailTransaksi'])->name('admin.transaksi.detail');

// ROUTE BARU PENGIRIMAN
Route::get('/admin/pengiriman', [AdminController::class, 'pengiriman'])->name('admin.pengiriman');

// ROUTE BARU PESAN
Route::get('/admin/pesan', [AdminController::class, 'pesan'])->name('admin.pesan');

// ROUTE BARU PESANAN BARU
Route::get('/admin/pesanan-baru', [AdminController::class, 'pesananBaru'])->name('admin.pesanan_baru');

Route::get('/daftar', function () {
    return view('auth.daftar');
})->name('daftar');

// Sesuaikan return view() dengan nama folder tempat kamu menyimpan login.blade.php
Route::get('/login', function () {
    return view('auth.login'); 
})->name('login');