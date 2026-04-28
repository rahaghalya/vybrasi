<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Fungsi untuk halaman Beranda Admin
    public function index()
    {
        return view('pages_admin.beranda');
    }

    // Fungsi untuk halaman Manajemen Produk
    public function produk()
    {
        return view('pages_admin.manajemen_produk');
    }

     // Fungsi untuk halaman tambah produk
    public function tambahProduk()
    {
        return view('pages_admin.tambah_produk');
    }

    // FUNGSI BARU UNTUK EDIT PRODUK
    public function editProduk($id = null) 
    {
        return view('pages_admin.edit_produk');
    }

// FUNGSI BARU UNTUK AFFILIATE
    public function affiliate()
    {
        return view('pages_admin.manajemen_affiliate');
    }

    // FUNGSI UNTUK TAMBAH AFFILIATE
    public function tambahAffiliate()
    {
        return view('pages_admin.tambah_affiliate');
    }

    // FUNGSI UNTUK LIHAT/EDIT PROFIL AFFILIATE
    public function profilAffiliate($id = null)
    {
        return view('pages_admin.profil_affiliate');
    }

    // FUNGSI BARU UNTUK LAPORAN TRANSAKSI
    public function laporanTransaksi()
    {
        return view('pages_admin.laporan_transaksi');
    }

// FUNGSI UNTUK LIHAT DETAIL TRANSAKSI / INVOICE
    public function detailTransaksi($id = null)
    {
        return view('pages_admin.detail_transaksi');
    }

    // FUNGSI BARU UNTUK PENGIRIMAN
    public function pengiriman()
    {
        return view('pages_admin.pengiriman');
    }

    // FUNGSI BARU UNTUK PESAN
    public function pesan()
    {
        return view('pages_admin.pesan');
    }

    // FUNGSI BARU UNTUK PESANAN MASUK
    public function pesananBaru()
    {
        return view('pages_admin.pesanan_baru');
    }
}