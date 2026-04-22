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

// Route untuk Admin Vybrasi
Route::get('/admin/beranda', [AdminController::class, 'index']);