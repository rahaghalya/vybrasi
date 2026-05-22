<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    // ---------------------------------------------------------
    // BERANDA ADMIN (DASHBOARD)
    // ---------------------------------------------------------
    public function index()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();

        $todayRevenue = DB::table('jualan_kopi.transaksi')->whereDate('created_at', $today)->where('status', 'delivered')->sum('total_harga');
        $todayOrders = DB::table('jualan_kopi.transaksi')->whereDate('created_at', $today)->where('status', 'delivered')->count();
        $weekRevenue = DB::table('jualan_kopi.transaksi')->where('created_at', '>=', $startOfWeek)->where('status', 'delivered')->sum('total_harga');
        $weekOrders = DB::table('jualan_kopi.transaksi')->where('created_at', '>=', $startOfWeek)->where('status', 'delivered')->count();

        $chartRevenue = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $rev = DB::table('jualan_kopi.transaksi')
                ->whereDate('created_at', $date)
                ->where('status', 'delivered')
                ->sum('total_harga');
            $chartLabels[] = $date->translatedFormat('d M');
            $chartRevenue[] = (int)$rev;
        }

        $statusCounts = [
            'pending'   => DB::table('jualan_kopi.transaksi')->where('status', 'pending')->count(),
            'shipped'   => DB::table('jualan_kopi.transaksi')->where('status', 'shipped')->count(),
            'delivered' => DB::table('jualan_kopi.transaksi')->where('status', 'delivered')->count(),
        ];

        $bestSellingProduct = DB::table('jualan_kopi.transaksi_detail')
            ->join('jualan_kopi.produk', 'transaksi_detail.id_produk', '=', 'produk.id_produk')
            ->select('produk.id_produk', 'produk.nama', 'produk.gambar_utama', DB::raw('SUM(transaksi_detail.jumlah) as total_terjual'))
            ->groupBy('produk.id_produk', 'produk.nama', 'produk.gambar_utama')
            ->orderByDesc('total_terjual')->first();

        $lowStockCount = DB::table('jualan_kopi.produk')->where('stok', '<=', 10)->count();
        $shippedCount = $statusCounts['shipped'];
        $deliveredCount = $statusCounts['delivered'];

        $recentOrdersRaw = DB::table('jualan_kopi.transaksi')->orderBy('created_at', 'desc')->limit(5)->get();
        $recentOrders = [];
        foreach($recentOrdersRaw as $order) {
            $namaPelanggan = 'Pelanggan';
            if (preg_match('/Penerima:\s*([^|]+)/', $order->catatan, $matches)) { $namaPelanggan = trim($matches[1]); }
            $detail = DB::table('jualan_kopi.transaksi_detail')->where('id_transaksi', $order->id_transaksi)->first();
            $recentOrders[] = (object)[
                'no_invoice' => $order->no_invoice,
                'nama_pelanggan' => $namaPelanggan,
                'produk_utama' => $detail ? $detail->nama_produk : 'Produk Kopi',
                'status' => $order->status
            ];
        }

        $recentLogs = DB::table('jualan_kopi.produk')->orderBy('updated_at', 'desc')->limit(5)->get();

        return view('pages_admin.beranda', compact(
            'todayRevenue', 'todayOrders', 'weekRevenue', 'weekOrders',
            'bestSellingProduct', 'lowStockCount', 'shippedCount', 'deliveredCount',
            'recentOrders', 'recentLogs',
            'chartLabels', 'chartRevenue', 'statusCounts'
        ));
    }

    public function apiChartPendapatan(Request $request)
    {
        $range = $request->get('range', '7days');
        $chartRevenue = [];
        $chartLabels = [];

        if ($range == '1month') {
            for ($i = 3; $i >= 0; $i--) {
                $startOfWeek = Carbon::today()->subWeeks($i)->startOfWeek();
                $endOfWeek = Carbon::today()->subWeeks($i)->endOfWeek();
                $rev = DB::table('jualan_kopi.transaksi')
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->where('status', 'delivered')->sum('total_harga');
                $chartLabels[] = 'Mg ' . (4-$i);
                $chartRevenue[] = (int)$rev;
            }
        } elseif ($range == '6months') {
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::today()->subMonths($i);
                $rev = DB::table('jualan_kopi.transaksi')
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->where('status', 'delivered')->sum('total_harga');
                $chartLabels[] = $date->translatedFormat('M y');
                $chartRevenue[] = (int)$rev;
            }
        } elseif ($range == '1year') {
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::today()->subMonths($i);
                $rev = DB::table('jualan_kopi.transaksi')
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->where('status', 'delivered')->sum('total_harga');
                $chartLabels[] = $date->translatedFormat('M y');
                $chartRevenue[] = (int)$rev;
            }
        } else {
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $rev = DB::table('jualan_kopi.transaksi')
                    ->whereDate('created_at', $date)
                    ->where('status', 'delivered')->sum('total_harga');
                $chartLabels[] = $date->translatedFormat('d M');
                $chartRevenue[] = (int)$rev;
            }
        }

        return response()->json(['labels' => $chartLabels, 'revenue' => $chartRevenue]);
    }

    public function produk(Request $request)
    {
        $query = DB::table('jualan_kopi.produk');
        if ($request->filled('search')) {
            $query->where('nama', 'ilike', '%' . $request->search . '%');
        }
        if ($request->filled('stok') && $request->stok == 'menipis') {
            $query->where('stok', '<=', 10);
        }
        $produks = $query->orderBy('created_at', 'desc')->paginate(8)->withQueryString();
        $totalProduk = DB::table('jualan_kopi.produk')->count();
        return view('pages_admin.manajemen_produk', compact('produks', 'totalProduk'));
    }

    public function tambahProduk() { return view('pages_admin.tambah_produk'); }

    public function storeProduk(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255', 'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0', 'berat_gram' => 'required|numeric|min:0',
            'deskripsi' => 'required|string', 'gambar_utama' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gambarUrl = null;
        if ($request->hasFile('gambar_utama')) {
            $path = $request->file('gambar_utama')->store('produk_images', 'public');
            $gambarUrl = asset('storage/' . $path);
        }

        DB::table('jualan_kopi.produk')->insert([
            'id_produk' => Str::uuid(), 'nama' => $request->nama, 'slug' => Str::slug($request->nama) . '-' . time(),
            'harga' => $request->harga, 'stok' => $request->stok, 'berat_gram' => $request->berat_gram,
            'deskripsi_singkat' => $request->deskripsi, 'gambar_utama' => $gambarUrl,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function editProduk($id)
    {
        $produk = DB::table('jualan_kopi.produk')->where('id_produk', $id)->first();
        if (!$produk) return redirect()->route('admin.produk')->with('error', 'Data produk tidak ditemukan.');
        return view('pages_admin.edit_produk', compact('produk'));
    }

    public function updateProduk(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255', 'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0', 'berat_gram' => 'required|numeric|min:0',
            'deskripsi' => 'required|string', 'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $updateData = [
            'nama' => $request->nama, 'slug' => Str::slug($request->nama) . '-' . time(),
            'harga' => $request->harga, 'stok' => $request->stok, 'berat_gram' => $request->berat_gram,
            'deskripsi_singkat' => $request->deskripsi, 'updated_at' => now(),
        ];

        if ($request->hasFile('gambar_utama')) {
            $path = $request->file('gambar_utama')->store('produk_images', 'public');
            $updateData['gambar_utama'] = asset('storage/' . $path);
        }

        DB::table('jualan_kopi.produk')->where('id_produk', $id)->update($updateData);
        return redirect()->route('admin.produk')->with('success', 'Data produk berhasil diperbarui!');
    }

    public function hapusProduk($id)
    {
        DB::table('jualan_kopi.produk')->where('id_produk', $id)->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus secara permanen.');
    }

    // ---------------------------------------------------------
    // MANAJEMEN AFFILIATE
    // ---------------------------------------------------------
    public function affiliate(Request $request)
    {
        $query = DB::table('jualan_kopi.profiles')
            ->leftJoin('jualan_kopi.affiliate_profiles', 'jualan_kopi.profiles.id', '=', 'jualan_kopi.affiliate_profiles.profile_id')
            ->where('jualan_kopi.profiles.role', 'affiliate')
            ->select(
                'jualan_kopi.profiles.id',
                'jualan_kopi.profiles.username',
                'jualan_kopi.profiles.full_name',
                'jualan_kopi.profiles.email',
                'jualan_kopi.profiles.phone',
                'jualan_kopi.profiles.kode_unik',
                'jualan_kopi.profiles.created_at',
                'jualan_kopi.affiliate_profiles.id_affiliate',
                'jualan_kopi.affiliate_profiles.kode_referal',
                'jualan_kopi.affiliate_profiles.komisi_persen',
                'jualan_kopi.affiliate_profiles.total_komisi',
                'jualan_kopi.affiliate_profiles.minimum_payout',
                'jualan_kopi.affiliate_profiles.status_affiliate',
                'jualan_kopi.affiliate_profiles.payment_method'
            );

        // FIX: Tambahan Query untuk Filter Status dari Tab
        if ($request->filled('status')) {
            $query->where('jualan_kopi.affiliate_profiles.status_affiliate', $request->status);
        }

        $affiliates = $query->orderBy('jualan_kopi.profiles.created_at', 'desc')->get();

        return view('pages_admin.manajemen_affiliate', compact('affiliates'));
    }

    public function tambahAffiliate() { return view('pages_admin.tambah_affiliate'); }

    public function storeAffiliate(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email'     => 'required|email|max:255',
        'phone'     => 'required|string|max:20',
        'kode_unik' => 'required|string',
        'password'  => 'nullable|string',
    ]);
 
    // Cek email sudah dipakai belum
    $existsEmail = DB::table('jualan_kopi.profiles')->where('email', $request->email)->exists();
    if ($existsEmail) {
        return redirect()->back()->withInput()->with('error', 'Email ini sudah terdaftar di sistem.');
    }
 
    // --- 1. Tentukan password ---
    $passwordToSave = $request->password;
    if (empty($passwordToSave)) {
        $namaDepan          = strtolower(explode(' ', trim($request->full_name))[0]);
        $empatDigitTerakhir = substr($request->phone, -4);
        $passwordToSave     = $namaDepan . $empatDigitTerakhir;
    }
 
    $supabaseUrl = 'https://jrgoxsxvccbcowqqrgxl.supabase.co';
    $supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImpyZ294c3h2Y2NiY293cXFyZ3hsIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3ODExMTI4MiwiZXhwIjoyMDkzNjg3MjgyfQ.cp8n6VShtxeOZ6UtjvLHsHKLdz_rsvWWxF0jMw4qrac';
 
    // --- 2. Buat user di Supabase Auth ---
    $response = \Illuminate\Support\Facades\Http::withoutVerifying()
        ->withHeaders([
            'apikey'        => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey,
            'Content-Type'  => 'application/json',
        ])->post("{$supabaseUrl}/auth/v1/admin/users", [
            'email'         => $request->email,
            'password'      => $passwordToSave,
            'email_confirm' => true,
        ]);
 
    if (!$response->successful()) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal membuat akun Auth Supabase: ' . ($response->json()['msg'] ?? $response->body()));
    }
 
    $authUserId = $response->json()['id'];
 
    $usernameClean = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->full_name));
    $autoUsername  = $usernameClean . '_' . rand(1000, 9999);
    $kodeReferal   = 'REF-' . strtoupper(Str::random(6));
 
    // --- 3. RETRY LOOP: tunggu trigger Supabase membuat profile ---
    // Lebih handal daripada usleep() dengan waktu tetap
    $profileId      = null;
    $existingProfile = null;
    $maxAttempts    = 8;   // coba maksimal 8 kali
    $delayMs        = 400; // jeda antar percobaan: 400ms
 
    for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
        usleep($delayMs * 1000);
        $existingProfile = DB::table('jualan_kopi.profiles')->where('user_id', $authUserId)->first();
        if ($existingProfile) {
            break; // Profile sudah ada, keluar dari loop
        }
    }
 
    try {
        if ($existingProfile) {
            // --- SKENARIO A: Trigger Supabase sudah buat profile ---
            // Cukup UPDATE role + data mitra, jangan INSERT ulang
            $profileId = $existingProfile->id;
 
            DB::table('jualan_kopi.profiles')
                ->where('id', $profileId)
                ->update([
                    'full_name'  => $request->full_name,
                    'email'      => $request->email,
                    'phone'      => $request->phone,
                    'kode_unik'  => $request->kode_unik,
                    'password'   => Hash::make($passwordToSave),
                    // UPDATE role ke affiliate — ini kunci utamanya
                    'role'       => DB::raw("'affiliate'::jualan_kopi.user_role"),
                    'can_shop'   => DB::raw('true'),
                    'updated_at' => now(),
                ]);
 
        } else {
            // --- SKENARIO B: Trigger tidak jalan sama sekali ---
            // INSERT manual dengan role affiliate dari awal
            $profileId = (string) Str::uuid();
 
            DB::table('jualan_kopi.profiles')->insert([
                'id'         => $profileId,
                'user_id'    => $authUserId,
                'username'   => $autoUsername,
                'full_name'  => $request->full_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'kode_unik'  => $request->kode_unik,
                'password'   => Hash::make($passwordToSave),
                'role'       => DB::raw("'affiliate'::jualan_kopi.user_role"),
                'can_shop'   => DB::raw('true'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
 
        // --- 4. Tambah ke affiliate_profiles (kalau belum ada) ---
        $cekAffiliate = DB::table('jualan_kopi.affiliate_profiles')
            ->where('profile_id', $profileId)
            ->exists();
 
        if (!$cekAffiliate) {
            DB::table('jualan_kopi.affiliate_profiles')->insert([
                'id_affiliate'     => (string) Str::uuid(),
                'profile_id'       => $profileId,
                'nama_lengkap'     => $request->full_name,
                'kode_referal'     => $kodeReferal,
                'komisi_persen'    => 5.00,
                'total_komisi'     => 0,
                'minimum_payout'   => 100000,
                'status_affiliate' => 'active',
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
 
    } catch (\Exception $e) {
        // Tampilkan error sebenarnya agar mudah di-debug
        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal menyimpan data mitra ke database: ' . $e->getMessage());
    }
 
    // --- 5. Redirect + session popup ---
    return redirect()->route('admin.affiliate')
        ->with('affiliate_baru', [
            'nama'     => $request->full_name,
            'email'    => $request->email,
            'password' => $passwordToSave,
            'kode'     => $request->kode_unik,
        ]);
}
    
    public function profilAffiliate($id)
    {
        $affiliate = DB::table('jualan_kopi.profiles')
            ->leftJoin('jualan_kopi.affiliate_profiles', 'jualan_kopi.profiles.id', '=', 'jualan_kopi.affiliate_profiles.profile_id')
            ->select(
                'jualan_kopi.profiles.*',
                'jualan_kopi.affiliate_profiles.total_komisi',
                'jualan_kopi.affiliate_profiles.kode_referal',
                'jualan_kopi.affiliate_profiles.id_affiliate',
                'jualan_kopi.affiliate_profiles.status_affiliate',
                'jualan_kopi.affiliate_profiles.komisi_persen',
                'jualan_kopi.affiliate_profiles.minimum_payout',
            )
            ->where('jualan_kopi.profiles.id', $id)
            ->first();

        if (!$affiliate) {
            return redirect()->route('admin.affiliate')->with('error', 'Mitra tidak ditemukan.');
        }

        $stats = (object)[
            'total_pesanan' => DB::table('jualan_kopi.komisi_histori')
                ->where('id_affiliate', $affiliate->id_affiliate)->count(),
        ];

        $payoutHistory = DB::table('jualan_kopi.payout_requests')
            ->where('id_affiliate', $affiliate->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $komisiHistori = DB::table('jualan_kopi.komisi_histori as kh')
            ->join('jualan_kopi.transaksi as t', 'kh.id_transaksi', '=', 't.id_transaksi')
            ->select('kh.*', 't.no_invoice')
            ->where('kh.id_affiliate', $affiliate->id_affiliate)
            ->orderBy('kh.created_at', 'desc')
            ->take(10)
            ->get();

        return view('pages_admin.profil_affiliate', compact('affiliate', 'stats', 'payoutHistory', 'komisiHistori'));
    }

    public function updateProfilAffiliate(Request $request, $id)
    {
        $request->validate([
            'full_name'        => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'required|string|max:20',
            'status_affiliate' => 'required|in:active,inactive,suspended',
        ]);

        DB::table('jualan_kopi.profiles')->where('id', $id)->update([
            'full_name'  => $request->full_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'updated_at' => now(),
        ]);

        DB::table('jualan_kopi.affiliate_profiles')->where('profile_id', $id)->update([
            'status_affiliate' => $request->status_affiliate,
            'updated_at'       => now(),
        ]);

        return redirect()->route('admin.affiliate.profil', $id)->with('success', 'Profil dan status mitra berhasil diperbarui!');
    }

    // ---------------------------------------------------------
    // LAPORAN & DETAIL TRANSAKSI
    // ---------------------------------------------------------
    public function laporanTransaksi(Request $request)
    {
        $query = DB::table('jualan_kopi.transaksi')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where('no_invoice', 'ilike', '%' . $request->search . '%');
        }
        if ($request->filled('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }
        if ($request->filled('bulan')) {
            $pecah = explode('-', $request->bulan);
            $query->whereYear('created_at', $pecah[0])->whereMonth('created_at', $pecah[1]);
        }

        $transaksis = $query->paginate(10)->withQueryString();
        $totalTransaksi = $query->count();

        return view('pages_admin.laporan_transaksi', compact('transaksis', 'totalTransaksi'));
    }

    public function exportPdfLaporan(Request $request)
    {
        $query = DB::table('jualan_kopi.transaksi')->orderBy('created_at', 'desc');
        if ($request->filled('search')) {
            $query->where('no_invoice', 'ilike', '%' . $request->search . '%');
        }
        if ($request->filled('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }
        $transaksis = $query->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages_admin.pdf_laporan', compact('transaksis'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Laporan_Transaksi_Vybrasi_' . date('Ymd') . '.pdf');
    }

    public function detailTransaksi($id)
    {
        $transaksi = DB::table('jualan_kopi.transaksi')->where('id_transaksi', $id)->first();
        if (!$transaksi) { return redirect()->route('admin.laporan')->with('error', 'Transaksi tidak ditemukan.'); }

        $pelanggan = (object)['nama' => 'Pelanggan', 'telepon' => '-', 'alamat' => '-'];
        if (preg_match('/Penerima:\s*([^|]+)/', $transaksi->catatan, $m)) $pelanggan->nama = trim($m[1]);
        if (preg_match('/WA:\s*([^|]+)/', $transaksi->catatan, $m)) $pelanggan->telepon = trim($m[1]);
        if (preg_match('/Alamat:\s*(.+)/', $transaksi->catatan, $m)) $pelanggan->alamat = trim($m[1]);

        $details = DB::table('jualan_kopi.transaksi_detail')
            ->leftJoin('jualan_kopi.produk', 'transaksi_detail.id_produk', '=', 'produk.id_produk')
            ->select('transaksi_detail.*')
            ->where('id_transaksi', $id)
            ->get();

        $subtotalProduk = 0;
        foreach($details as $d) { $subtotalProduk += $d->subtotal; }

        return view('pages_admin.detail_transaksi', compact('transaksi', 'pelanggan', 'details', 'subtotalProduk'));
    }

    // ---------------------------------------------------------
    // PENGIRIMAN
    // ---------------------------------------------------------
    public function pengiriman(Request $request)
    {
        $query = DB::table('jualan_kopi.transaksi')->orderBy('created_at', 'desc');
        if ($request->filled('search')) { $query->where('no_invoice', 'ilike', '%' . $request->search . '%'); }
        if ($request->filled('status')) { $query->where('status', $request->status); }

        $allPengiriman = $query->get();
        $countSiap = DB::table('jualan_kopi.transaksi')->where('status', 'pending')->count();
        $countJalan = DB::table('jualan_kopi.transaksi')->where('status', 'shipped')->count();
        $countTiba = DB::table('jualan_kopi.transaksi')->where('status', 'delivered')->count();

        return view('pages_admin.pengiriman', compact('allPengiriman', 'countSiap', 'countJalan', 'countTiba'));
    }

    public function cetakResi($id)
    {
        $transaksi = DB::table('jualan_kopi.transaksi')->where('id_transaksi', $id)->first();
        if (!$transaksi) {
            return redirect()->back()->with('error', 'Data pesanan tidak ditemukan.');
        }

        $pelanggan = (object)['nama' => 'Pelanggan', 'telepon' => '-', 'alamat' => '-'];
        if (preg_match('/Penerima:\s*([^|]+)/', $transaksi->catatan, $m)) $pelanggan->nama = trim($m[1]);
        if (preg_match('/WA:\s*([^|]+)/', $transaksi->catatan, $m)) $pelanggan->telepon = trim($m[1]);
        if (preg_match('/Alamat:\s*(.+)/', $transaksi->catatan, $m)) $pelanggan->alamat = trim($m[1]);

        $details = DB::table('jualan_kopi.transaksi_detail')->where('id_transaksi', $id)->get();

        return view('pages_admin.cetak_resi', compact('transaksi', 'pelanggan', 'details'));
    }

    public function updatePengiriman(Request $request)
    {
        $request->validate([
            'id_transaksi'      => 'required',
            'status_pengiriman' => 'required|in:shipped,delivered',
            'bukti_pengiriman'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $updateData = ['status' => $request->status_pengiriman, 'updated_at' => now()];

        if ($request->hasFile('bukti_pengiriman')) {
            $path = $request->file('bukti_pengiriman')->store('bukti_resi', 'public');
            $urlBukti = asset('storage/' . $path);
            $transaksi = DB::table('jualan_kopi.transaksi')->where('id_transaksi', $request->id_transaksi)->first();
            $updateData['catatan'] = $transaksi->catatan . ' | Bukti: ' . $urlBukti;
        }

        DB::table('jualan_kopi.transaksi')->where('id_transaksi', $request->id_transaksi)->update($updateData);

        // FIX: Jika status diubah jadi delivered, cairkan komisi affiliate
        if ($request->status_pengiriman === 'delivered') {
            $this->prosesKomisiAffiliate($request->id_transaksi);
        }

        return redirect()->back()->with('success', 'Status Pengiriman Berhasil Diperbarui!');
    }

    // ---------------------------------------------------------
    // KITCHEN DISPLAY / KANBAN (PESANAN BARU)
    // ---------------------------------------------------------
    public function pesananBaru()
    {
        $masuk = DB::table('jualan_kopi.transaksi')->where('status', 'pending')->orderBy('created_at', 'asc')->get();
        $racik = DB::table('jualan_kopi.transaksi')->where('status', 'shipped')->orderBy('created_at', 'asc')->get();
        $siap  = DB::table('jualan_kopi.transaksi')->where('status', 'delivered')->orderBy('created_at', 'asc')->get();

        foreach([$masuk, $racik, $siap] as $kumpulan) {
            foreach($kumpulan as $trx) {
                $trx->items = DB::table('jualan_kopi.transaksi_detail')->where('id_transaksi', $trx->id_transaksi)->get();
                $trx->nama_pelanggan = 'Pelanggan';
                if (preg_match('/Penerima:\s*([^|]+)/', $trx->catatan, $m)) $trx->nama_pelanggan = trim($m[1]);
            }
        }

        return view('pages_admin.pesanan_baru', compact('masuk', 'racik', 'siap'));
    }

    public function updateStatusPesanan($id, $status)
    {
        DB::table('jualan_kopi.transaksi')->where('id_transaksi', $id)->update(['status' => $status, 'updated_at' => now()]);
        
        // FIX: Jika dipindah ke kolom Selesai (delivered), cairkan komisi affiliate
        if ($status === 'delivered') {
            $this->prosesKomisiAffiliate($id);
        }

        return response()->json(['success' => true]);
    }

    // ---------------------------------------------------------
    // PESAN MASUK (INBOX TESTIMONI)
    // ---------------------------------------------------------
    public function pesan()
    {
        $pesans = DB::table('jualan_kopi.testimoni')->orderBy('created_at', 'desc')->get();
        return view('pages_admin.pesan', compact('pesans'));
    }

    public function toggleTestimoni($id)
    {
        $testimoni = DB::table('jualan_kopi.testimoni')->where('id_testimoni', $id)->first();
        if($testimoni) {
            $newStatus = !($testimoni->is_tampil ?? false);
            DB::table('jualan_kopi.testimoni')->where('id_testimoni', $id)->update(['is_tampil' => $newStatus]);
            return response()->json(['success' => true, 'is_tampil' => $newStatus]);
        }
        return response()->json(['success' => false]);
    }

    public function hapusTestimoni($id)
    {
        DB::table('jualan_kopi.testimoni')->where('id_testimoni', $id)->delete();
        return response()->json(['success' => true]);
    }

    // ---------------------------------------------------------
    // TESTIMONI (TAMPILAN BIASA)
    // ---------------------------------------------------------
    public function testimoni()
    {
        $testimonis = DB::table('jualan_kopi.testimoni')
            ->leftJoin('jualan_kopi.produk', 'testimoni.id_produk', '=', 'produk.id_produk')
            ->select('testimoni.*', 'produk.nama as nama_produk')
            ->orderBy('testimoni.created_at', 'desc')
            ->get();
        return view('pages_admin.manajemen_testimoni', compact('testimonis'));
    }

    // ---------------------------------------------------------
    // MANAJEMEN KONTEN (CMS) TERPISAH
    // ---------------------------------------------------------
    public function cmsBeranda() {
        $cms = DB::table('jualan_kopi.settings')->pluck('value', 'key')->toArray();
        return view('pages_admin.cms_beranda', compact('cms'));
    }

    public function cmsTentang() {
        $cms = DB::table('jualan_kopi.settings')->pluck('value', 'key')->toArray();
        return view('pages_admin.cms_tentang', compact('cms'));
    }

    public function cmsKontak() {
        $cms = DB::table('jualan_kopi.settings')->pluck('value', 'key')->toArray();
        return view('pages_admin.cms_kontak', compact('cms'));
    }

    public function updateKonten(Request $request) {
        $data = $request->except(['_token']);
        foreach($data as $key => $value) {
            if (!$request->hasFile($key)) {
                DB::table('jualan_kopi.settings')->updateOrInsert(['key' => $key], ['value' => $value, 'updated_at' => now()]);
            }
        }
        foreach($request->allFiles() as $key => $file) {
            $path = $file->store('cms', 'public');
            DB::table('jualan_kopi.settings')->updateOrInsert(['key' => $key], ['value' => 'storage/'.$path, 'updated_at' => now()]);
        }
        return redirect()->back()->with('success', 'Konten berhasil diperbarui!');
    }

    // ---------------------------------------------------------
    // HELPER PENCAIRAN KOMISI OTOMATIS
    // ---------------------------------------------------------
    private function prosesKomisiAffiliate($id_transaksi)
    {
        // Cari semua komisi tertunda (pending) yang terkait dengan transaksi ini
        $komisis = DB::table('jualan_kopi.komisi_histori')
            ->where('id_transaksi', $id_transaksi)
            ->where('status_komisi', 'pending')
            ->get();

        foreach ($komisis as $k) {
            // 1. Tambah uang ke saldo utama affiliate
            DB::table('jualan_kopi.affiliate_profiles')
                ->where('id_affiliate', $k->id_affiliate)
                ->increment('total_komisi', $k->jumlah_komisi);

            // 2. Ubah status historinya menjadi sukses agar tidak dicairkan dobel
            DB::table('jualan_kopi.komisi_histori')
                ->where('id_histori', $k->id_histori)
                ->update([
                    'status_komisi' => 'sukses', 
                    'updated_at'    => now()
                ]);
        }
    }
}