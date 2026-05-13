<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Models\Produk;

// --- RUTE PUBLIK (Tanpa Login) ---
Route::get('/', function () {
    $featuredProducts = App\Models\Produk::where('is_featured', true)->take(8)->get();
    $products = App\Models\Produk::latest()->take(6)->get(); 
    
    $testimonials = \Illuminate\Support\Facades\DB::table('jualan_kopi.testimoni')
        ->where('is_tampil', true)
        ->whereNull('id_produk') 
        ->orderBy('created_at', 'desc')->take(3)->get();
        
    return view('pages.beranda', compact('featuredProducts', 'products', 'testimonials')); 
})->name('beranda');

Route::get('/produk', function (\Illuminate\Http\Request $request) {
    $query = \Illuminate\Support\Facades\DB::table('jualan_kopi.produk')
        ->orderBy('created_at', 'desc');

    // Filter Pencarian Nama
    if ($request->filled('search')) {
        $query->where('nama', 'ilike', '%' . $request->search . '%');
    }

    // Filter Kategori (Sekarang berupa String tunggal dari Radio Button)
    if ($request->filled('kategori')) {
        $kategori = $request->kategori;
        
        if ($kategori == 'gula_aren') {
            $query->where('nama', 'ilike', '%gula aren%');
        } elseif ($kategori == 'signature') {
            $query->where('nama', 'ilike', '%signature%');
        } elseif ($kategori == 'unggulan') {
            // Misalnya produk unggulan ditandai dengan harga di atas 50rb atau kriteria lain.
            // Jika tidak ada kolom khusus, kita filter berdasarkan keyword tertentu.
            $query->where('nama', 'ilike', '%blend%')->orWhere('harga', '>', 50000); 
        }
    }

    // Filter Stok (Sekarang berupa String tunggal dari Radio Button)
    if ($request->filled('stok')) {
        $stok = $request->stok;
        if ($stok == 'tersedia') {
            $query->where('stok', '>', 0);
        } elseif ($stok == 'habis') {
            $query->where('stok', '=', 0);
        }
    } else {
        // Default: hanya tampilkan yang stoknya tersedia jika user belum memilih filter
        $query->where('stok', '>', 0);
    }

    $produks = $query->paginate(9)->withQueryString();

    return view('pages.produk', compact('produks'));
})->name('produk');

Route::get('/produk/{slug}', function ($slug) {
    $produk = App\Models\Produk::with(['ulasan' => function($q) {
        $q->where('is_hidden', 0);
    }, 'ulasan.user'])->where('slug', $slug)->firstOrFail();
    
    return view('pages.detail-produk', compact('produk')); 
})->name('produk.detail');

Route::get('/tentang', function () { return view('pages.tentang'); })->name('tentang');
Route::get('/kontak', function () { return view('pages.kontak'); })->name('kontak');


// --- RUTE AUTENTIKASI ---
Route::get('/daftar', [AuthController::class, 'showDaftarForm'])->name('daftar');
Route::post('/proses-daftar', [AuthController::class, 'prosesDaftar'])->name('daftar.proses');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login/proses', [AuthController::class, 'prosesLogin'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- RUTE USER TERAUTENTIKASI ---
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', function () { return view('pages.profil'); })->name('profil');

    Route::get('/view-profil', function () {
        $user = auth()->user();
        $alamat = \Illuminate\Support\Facades\DB::table('jualan_kopi.alamat_pengiriman')
                    ->where('user_id', $user->id)->orderBy('is_primary', 'desc')->first();
        return view('pages.view-profil', compact('alamat'));
    })->name('profil.view');

    Route::get('/edit-profil', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/edit-profil/update', [ProfileController::class, 'update'])->name('profil.update');

    Route::get('/riwayat-pesanan', function () {
        $pesanan = \Illuminate\Support\Facades\DB::table('jualan_kopi.transaksi')
            ->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        foreach($pesanan as $p) {
            $p->produk_dibeli = \Illuminate\Support\Facades\DB::table('jualan_kopi.transaksi_detail')
                ->where('id_transaksi', $p->id_transaksi)
                ->select('id_produk', 'nama_produk')
                ->get();
        }
        return view('pages.riwayat-pesanan', compact('pesanan'));
    })->name('pesanan.riwayat');

    Route::post('/riwayat-pesanan/ulasan', function (\Illuminate\Http\Request $request) {
        // Validasi input dari form
        $request->validate([
            'jenis_ulasan' => 'required', 
            'nama'         => 'required',
            'invoice'      => 'required',
            'tanggal'      => 'required',
            'ulasan_teks'  => 'required',
            'rating'       => 'required|integer|min:1|max:5',
        ]);
        
        $id_produk = ($request->jenis_ulasan == 'produk') ? $request->id_produk : null;
        
        \Illuminate\Support\Facades\DB::table('jualan_kopi.testimoni')->insert([
            'id_testimoni'   => \Illuminate\Support\Str::uuid(),
            'id_produk'      => $id_produk,
            'nama_pelanggan' => $request->nama,
            'rating'         => $request->rating,
            'komentar'       => $request->ulasan_teks,
            
            // PERBAIKAN: Set menjadi false agar tidak langsung tampil di web
            'is_tampil'      => false, 
            
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
        
        return redirect()->back()->with('success', 'Terima kasih! Pesan Anda telah kami terima.');
    })->name('testimoni.store');

    Route::get('/keranjang', function () {
        $user = auth()->user();
        $cartItems = \Illuminate\Support\Facades\DB::table('jualan_kopi.keranjang')
            ->join('jualan_kopi.produk', 'keranjang.id_produk', '=', 'produk.id_produk') 
            ->where('keranjang.user_id', $user->id)
            ->select('keranjang.*', 'produk.nama', 'produk.harga', 'produk.gambar_utama', 'produk.berat_gram', 'produk.deskripsi_singkat')
            ->orderBy('keranjang.created_at', 'desc')->get();
        return view('pages.keranjang', compact('cartItems'));
    })->name('keranjang.index');

    Route::post('/keranjang/update-qty', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\DB::table('jualan_kopi.keranjang')
            ->where('id_keranjang', $request->id_keranjang)->where('user_id', auth()->user()->id)
            ->update(['jumlah' => $request->jumlah, 'updated_at' => now()]);
        return response()->json(['success' => true]);
    })->name('keranjang.update_qty');

    Route::delete('/keranjang/hapus', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\DB::table('jualan_kopi.keranjang')
            ->where('id_keranjang', $request->id_keranjang)
            ->where('user_id', auth()->user()->id)
            ->delete();
        return response()->json(['success' => true]);
    })->name('keranjang.hapus');

    Route::get('/keranjang/tambah', function () {
        return redirect()->route('produk')->with('error', 'Aksi tidak diizinkan.');
    });

    Route::post('/keranjang/tambah', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        if ($request->action == 'checkout') {
            session(['buy_now_item' => [
                'id_produk' => $request->id_produk,
                'jumlah'    => $request->jumlah ?? 1
            ]]);
            session()->forget('selected_items'); 
            return redirect()->route('checkout');
        }
        $existing = \Illuminate\Support\Facades\DB::table('jualan_kopi.keranjang')
            ->where('user_id', $user->id)->where('id_produk', $request->id_produk)->first();
        if ($existing) {
            \Illuminate\Support\Facades\DB::table('jualan_kopi.keranjang')
                ->where('id_keranjang', $existing->id_keranjang)
                ->update(['jumlah' => $existing->jumlah + $request->jumlah, 'updated_at' => now()]);
        } else {
            \Illuminate\Support\Facades\DB::table('jualan_kopi.keranjang')->insert([
                'id_keranjang' => \Illuminate\Support\Str::uuid(),
                'user_id'      => $user->id,
                'id_produk'    => $request->id_produk,
                'jumlah'       => $request->jumlah ?? 1,
                'created_at'   => now(), 'updated_at' => now()
            ]);
        }
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    })->name('keranjang.tambah');

    Route::get('/checkout', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        if ($request->has('item')) {
            session(['selected_items' => $request->item]);
            session()->forget('buy_now_item');
        }
        $daftarAlamat = \Illuminate\Support\Facades\DB::table('jualan_kopi.alamat_pengiriman')
                    ->where('user_id', $user->id)->orderBy('is_primary', 'desc')->get();
        $cartItems = collect(); 
        if (session()->has('buy_now_item')) {
            $buyNow = session('buy_now_item');
            $produkAsli = \Illuminate\Support\Facades\DB::table('jualan_kopi.produk')->where('id_produk', $buyNow['id_produk'])->first();
            if ($produkAsli) {
                $cartItems->push((object)[
                    'id_keranjang'    => 'vip-session',
                    'id_produk'       => $produkAsli->id_produk,
                    'nama'            => $produkAsli->nama,
                    'harga'           => $produkAsli->harga,
                    'gambar_utama'    => $produkAsli->gambar_utama,
                    'berat_gram'      => $produkAsli->berat_gram,
                    'deskripsi_singkat' => $produkAsli->deskripsi_singkat,
                    'jumlah'          => $buyNow['jumlah']
                ]);
            }
        } elseif (session()->has('selected_items')) {
            $cartItems = \Illuminate\Support\Facades\DB::table('jualan_kopi.keranjang')
                ->join('jualan_kopi.produk', 'keranjang.id_produk', '=', 'produk.id_produk') 
                ->where('keranjang.user_id', $user->id)
                ->whereIn('keranjang.id_keranjang', session('selected_items'))
                ->select('keranjang.*', 'produk.nama', 'produk.harga', 'produk.gambar_utama', 'produk.berat_gram', 'produk.deskripsi_singkat')
                ->get();
        }
        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Silakan pilih produk terlebih dahulu.');
        }
        $subtotal = 0;
        foreach($cartItems as $item) { $subtotal += ($item->harga * $item->jumlah); }
        return view('pages.checkout', compact('daftarAlamat', 'cartItems', 'subtotal'));
    })->name('checkout');

    Route::post('/checkout/proses', function (\Illuminate\Http\Request $request) {
        session(['checkout_data' => $request->all()]);
        return redirect()->route('pembayaran.metode');
    })->name('checkout.proses');

    Route::get('/metode-pembayaran', function () {
        return view('pages.pembayaran');
    })->name('pembayaran.metode');

    Route::post('/pembayaran/proses', function (\Illuminate\Http\Request $request) {
        session(['payment_method' => $request->metode_pembayaran]);
        return redirect()->route('pesanan.review');
    })->name('pembayaran.proses');

    Route::get('/review-pesanan', function () {
        $user = auth()->user();
        $checkoutData  = session('checkout_data');
        $paymentMethod = session('payment_method');
        if (!$checkoutData || !$paymentMethod) {
            return redirect()->route('keranjang.index')->with('error', 'Sesi habis, silakan ulangi checkout.');
        }
        $cartItems = collect();
        if (session()->has('buy_now_item')) {
            $buyNow = session('buy_now_item');
            $produkAsli = \Illuminate\Support\Facades\DB::table('jualan_kopi.produk')->where('id_produk', $buyNow['id_produk'])->first();
            if ($produkAsli) {
                $cartItems->push((object)[
                    'id_produk' => $produkAsli->id_produk,
                    'nama'      => $produkAsli->nama,
                    'harga'     => $produkAsli->harga,
                    'jumlah'    => $buyNow['jumlah']
                ]);
            }
        } elseif (session()->has('selected_items')) {
            $cartItems = \Illuminate\Support\Facades\DB::table('jualan_kopi.keranjang')
                ->join('jualan_kopi.produk', 'keranjang.id_produk', '=', 'produk.id_produk') 
                ->where('keranjang.user_id', $user->id)
                ->whereIn('keranjang.id_keranjang', session('selected_items'))
                ->select('keranjang.*', 'produk.nama', 'produk.harga')
                ->get();
        }
        if ($cartItems->isEmpty()) { return redirect()->route('keranjang.index'); }
        $subtotal = 0;
        foreach($cartItems as $item) { $subtotal += ($item->harga * $item->jumlah); }
        $ongkir = 10000;
        $total  = $subtotal + $ongkir;
        return view('pages.review-pesanan', compact('checkoutData', 'paymentMethod', 'cartItems', 'subtotal', 'ongkir', 'total'));
    })->name('pesanan.review');

    Route::post('/pesanan/konfirmasi', function (\Illuminate\Http\Request $request) {
        $user          = auth()->user();
        $checkoutData  = session('checkout_data');
        $paymentMethod = session('payment_method');

        if (!$checkoutData || !$paymentMethod) { return redirect()->route('keranjang.index'); }

        $cartItems = collect();
        if (session()->has('buy_now_item')) {
            $buyNow = session('buy_now_item');
            $produkAsli = \Illuminate\Support\Facades\DB::table('jualan_kopi.produk')->where('id_produk', $buyNow['id_produk'])->first();
            if ($produkAsli) {
                $cartItems->push((object)[
                    'id_produk'   => $produkAsli->id_produk,
                    'nama_produk' => $produkAsli->nama,
                    'harga'       => $produkAsli->harga,
                    'jumlah'      => $buyNow['jumlah']
                ]);
            }
        } elseif (session()->has('selected_items')) {
            $cartItems = \Illuminate\Support\Facades\DB::table('jualan_kopi.keranjang')
                ->join('jualan_kopi.produk', 'keranjang.id_produk', '=', 'produk.id_produk') 
                ->where('keranjang.user_id', $user->id)
                ->whereIn('keranjang.id_keranjang', session('selected_items'))
                ->select('keranjang.*', 'produk.nama as nama_produk', 'produk.harga')
                ->get();
        }

        if ($cartItems->isEmpty()) { return redirect()->route('keranjang.index'); }

        $subtotal   = 0;
        foreach($cartItems as $item) { $subtotal += ($item->harga * $item->jumlah); }
        $ongkir     = 10000;
        $totalBayar = $subtotal + $ongkir;
        $orderId    = 'INV-VYB-' . strtoupper(\Illuminate\Support\Str::random(5));
        $idTransaksi = \Illuminate\Support\Str::uuid();
        $catatanInfo = "Penerima: {$checkoutData['nama_lengkap']} | WA: {$checkoutData['no_wa']} | Alamat: {$checkoutData['alamat']}, {$checkoutData['kota']}";

        // 1. Simpan Alamat Baru Jika Dicentang
        if (isset($checkoutData['simpan_alamat']) && $checkoutData['simpan_alamat'] == '1') {
            \Illuminate\Support\Facades\DB::table('jualan_kopi.alamat_pengiriman')->insert([
                'id_alamat'      => \Illuminate\Support\Str::uuid(),
                'user_id'        => $user->id,
                'kota'           => $checkoutData['kota'],
                'alamat_lengkap' => $checkoutData['alamat'],
                'is_primary'     => false,
                'created_at'     => now(), 'updated_at' => now(),
            ]);
        }

        // 2. Insert Header Transaksi
        \Illuminate\Support\Facades\DB::table('jualan_kopi.transaksi')->insert([
            'id_transaksi'     => $idTransaksi,
            'no_invoice'       => $orderId,
            'user_id'          => $user->id,
            'subtotal'         => $subtotal,
            'biaya_pengiriman' => $ongkir,
            'diskon'           => 0,
            'total_harga'      => $totalBayar,
            'status'           => 'pending', 
            'metode_pembayaran' => $paymentMethod,
            'catatan'          => $catatanInfo,
            'created_at'       => now(), 'updated_at' => now(),
        ]);

        // 3. Insert Detail Transaksi DAN POTONG STOK
        foreach($cartItems as $item) {
            // Simpan Detail
            \Illuminate\Support\Facades\DB::table('jualan_kopi.transaksi_detail')->insert([
                'id_detail'   => \Illuminate\Support\Str::uuid(),
                'id_transaksi' => $idTransaksi,
                'id_produk'   => $item->id_produk,
                'nama_produk' => $item->nama_produk,
                'harga_satuan' => $item->harga,
                'jumlah'      => $item->jumlah,
                'subtotal'    => ($item->harga * $item->jumlah),
                'created_at'  => now(),
            ]);

            // --- LOGIKA POTONG STOK ---
            \Illuminate\Support\Facades\DB::table('jualan_kopi.produk')
                ->where('id_produk', $item->id_produk)
                ->decrement('stok', $item->jumlah);
        }

        // 4. Bersihkan Keranjang & Sesi
        if (session()->has('selected_items')) {
            \Illuminate\Support\Facades\DB::table('jualan_kopi.keranjang')
                ->whereIn('id_keranjang', session('selected_items'))->delete();
        }
        session()->forget(['checkout_data', 'payment_method', 'buy_now_item', 'selected_items']);
        session(['order_success' => ['orderId' => $orderId, 'paymentMethod' => $paymentMethod, 'totalBayar' => $totalBayar]]);

        return redirect()->route('pesanan.berhasil');
    })->name('pesanan.konfirmasi');

    Route::get('/pesanan-berhasil', function () {
        $orderSuccess = session('order_success');
        if (!$orderSuccess) { return redirect()->route('beranda'); }
        $orderId       = $orderSuccess['orderId'];
        $paymentMethod = $orderSuccess['paymentMethod'];
        $totalBayar    = $orderSuccess['totalBayar'];
        return view('pages.pesanan-berhasil', compact('paymentMethod', 'orderId', 'totalBayar')); 
    })->name('pesanan.berhasil');
});


// --- RUTE KHUSUS ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/beranda', [AdminController::class, 'index'])->name('admin.beranda');
    
    // API untuk Update Grafik Beranda
    Route::get('/admin/api/chart-pendapatan', [AdminController::class, 'apiChartPendapatan'])->name('admin.api.chart');

    // KELOMPOK RUTE MANAJEMEN KONTEN (CMS)
    Route::prefix('admin/manajemen-konten')->name('admin.konten.')->group(function () {
        Route::get('/beranda', [AdminController::class, 'cmsBeranda'])->name('beranda');
        Route::get('/tentang', [AdminController::class, 'cmsTentang'])->name('tentang');
        Route::get('/kontak', [AdminController::class, 'cmsKontak'])->name('kontak');
        Route::post('/update', [AdminController::class, 'updateKonten'])->name('update');
    });

    // PRODUK
    Route::get('/admin/produk', [AdminController::class, 'produk'])->name('admin.produk');
    Route::get('/admin/produk/tambah', [AdminController::class, 'tambahProduk'])->name('admin.produk.tambah');
    Route::post('/admin/produk/tambah', [AdminController::class, 'storeProduk'])->name('admin.produk.store');
    Route::get('/admin/produk/edit/{id}', [AdminController::class, 'editProduk'])->name('admin.produk.edit');
    Route::put('/admin/produk/update/{id}', [AdminController::class, 'updateProduk'])->name('admin.produk.update');
    Route::delete('/admin/produk/hapus/{id}', [AdminController::class, 'hapusProduk'])->name('admin.produk.hapus');
    
    // TRANSAKSI & LAPORAN
    Route::get('/admin/laporan-transaksi', [AdminController::class, 'laporanTransaksi'])->name('admin.laporan');
    Route::get('/admin/laporan-transaksi/pdf', [AdminController::class, 'exportPdfLaporan'])->name('admin.laporan.pdf');
    Route::get('/admin/transaksi/detail/{id}', [AdminController::class, 'detailTransaksi'])->name('admin.transaksi.detail');
    
    // PENGIRIMAN
    Route::get('/admin/pengiriman', [AdminController::class, 'pengiriman'])->name('admin.pengiriman');
    Route::post('/admin/pengiriman/update', [AdminController::class, 'updatePengiriman'])->name('admin.pengiriman.update');
    // PESAN & KANBAN PESANAN BARU
    Route::get('/admin/pesan', [AdminController::class, 'pesan'])->name('admin.pesan');
    Route::get('/admin/pesanan-baru', [AdminController::class, 'pesananBaru'])->name('admin.pesanan_baru');
    Route::post('/admin/pesanan-baru/update-status/{id}/{status}', [AdminController::class, 'updateStatusPesanan']); // Route AJAX untuk Kanban
    
    // TESTIMONI
    Route::get('/admin/testimoni', [AdminController::class, 'testimoni'])->name('admin.testimoni');
    Route::post('/admin/testimoni/toggle/{id}', [AdminController::class, 'toggleTestimoni']);
    Route::delete('/admin/testimoni/hapus/{id}', [AdminController::class, 'hapusTestimoni'])->name('admin.testimoni.hapus');

    // AFFILIATE
    Route::get('/admin/affiliate', [AdminController::class, 'affiliate'])->name('admin.affiliate');
    Route::get('/admin/affiliate/tambah', [AdminController::class, 'tambahAffiliate'])->name('admin.affiliate.tambah');
    Route::post('/admin/affiliate/tambah', [AdminController::class, 'storeAffiliate'])->name('admin.affiliate.store');
    Route::get('/admin/affiliate/profil/{id}', [AdminController::class, 'profilAffiliate'])->name('admin.affiliate.profil');
    Route::put('/admin/affiliate/profil/{id}', [AdminController::class, 'updateProfilAffiliate'])->name('admin.affiliate.update');

    // Rute untuk cetak resi pengiriman ber-Barcode
Route::get('/admin/pengiriman/cetak-resi/{id}', [App\Http\Controllers\AdminController::class, 'cetakResi'])->name('admin.pengiriman.cetak_resi');
});