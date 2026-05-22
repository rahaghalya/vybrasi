<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PayoutController extends Controller
{
    // =========================================================
    // ADMIN SIDE
    // =========================================================

    /**
     * Daftar semua pengajuan payout (Admin)
     */
    public function adminIndex(Request $request)
    {
        $query = DB::table('jualan_kopi.payout_requests as pr')
            ->join('jualan_kopi.profiles as p', 'p.id', '=', 'pr.id_affiliate')
            ->select(
                'pr.*',
                'p.full_name',
                'p.kode_unik',
                'p.email'
            )
            ->orderBy('pr.created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('pr.status', $request->status);
        }

        $payouts = $query->paginate(20);

        // Stats
        $stats = DB::table('jualan_kopi.payout_requests')
            ->selectRaw("
                COUNT(*) FILTER (WHERE status = 'pending')  AS pending,
                COUNT(*) FILTER (WHERE status = 'approved') AS approved,
                COUNT(*) FILTER (WHERE status = 'rejected') AS rejected,
                COALESCE(SUM(jumlah) FILTER (WHERE status = 'pending'), 0) AS total_pending_amount
            ")
            ->first();

        return view('pages_admin.admin_payout_index', compact('payouts', 'stats'));
    }

    /**
     * Detail satu pengajuan (Admin)
     */
    public function adminDetail($id)
    {
        $payout = DB::table('jualan_kopi.payout_requests as pr')
            ->join('jualan_kopi.profiles as p', 'p.id', '=', 'pr.id_affiliate')
            ->leftJoin('jualan_kopi.admin_profiles as ap', 'ap.id_admin', '=', 'pr.approved_by')
            ->leftJoin('jualan_kopi.profiles as rv', 'rv.id', '=', 'ap.profile_id')
            ->select(
                'pr.*',
                'p.full_name', 'p.kode_unik', 'p.email', 'p.phone',
                DB::raw("rv.full_name AS reviewer_name")
            )
            ->where('pr.id_request', $id)
            ->firstOrFail();

        // Data affiliate (saldo, dll.)
        $affiliate = DB::table('jualan_kopi.profiles as p')
            ->leftJoin('jualan_kopi.affiliate_profiles as ap', 'ap.profile_id', '=', 'p.id')
            ->select('p.*', 'ap.total_komisi', 'ap.minimum_payout', 'ap.kode_referal')
            ->where('p.id', $payout->id_affiliate)
            ->first();

        // Riwayat pengajuan affiliate ini (exclude yang sedang dilihat)
        $payoutHistory = DB::table('jualan_kopi.payout_requests')
            ->where('id_affiliate', $payout->id_affiliate)
            ->where('id_request', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('pages_admin.admin_payout_detail', compact('payout', 'affiliate', 'payoutHistory'));
    }

    /**
     * Setujui pengajuan (Admin)
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'keterangan_admin' => 'nullable|string|max:1000',
            'bukti_transfer'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $payout = DB::table('jualan_kopi.payout_requests')
            ->where('id_request', $id)
            ->where('status', 'pending')
            ->first();

        if (!$payout) {
            return redirect()->back()->with('error', 'Pengajuan tidak ditemukan atau sudah diproses.');
        }

        // Upload bukti transfer
        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')
                ->store('payout/bukti', 'public');
        }

        // Update status
        DB::table('jualan_kopi.payout_requests')
            ->where('id_request', $id)
            ->update([
                'status'           => 'approved',
                'keterangan_admin' => $request->keterangan_admin,
                'approved_by'      => $this->getAdminProfileId(),
                'reviewed_at'      => now(),
                'bukti_transfer'   => $buktiPath ? Storage::url($buktiPath) : null,
                'updated_at'       => now(),
            ]);

        // Kurangi total_komisi affiliate (trigger DB juga melakukan ini,
        // tapi aman untuk juga handle di sini sebagai fallback)
        DB::table('jualan_kopi.affiliate_profiles')
            ->where('profile_id', $payout->id_affiliate)
            ->decrement('total_komisi', $payout->jumlah);

        // Catat ke keuangan
        DB::table('jualan_kopi.keuangan')->insert([
            'id_keuangan'   => \Illuminate\Support\Str::uuid(),
            'id_affiliate'  => $payout->id_affiliate,
            'tipe'          => 'pengeluaran',
            'jumlah'        => $payout->jumlah,
            'status'        => 'completed',
            'keterangan'    => 'Payout komisi affiliate - Request #' . $id,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()
            ->route('admin.payout.index')
            ->with('success', 'Pengajuan berhasil disetujui. Komisi affiliate telah dikurangi.');
    }

    /**
     * Tolak pengajuan (Admin)
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'keterangan_admin' => 'required|string|min:10|max:1000',
        ], [
            'keterangan_admin.required' => 'Alasan penolakan wajib diisi.',
            'keterangan_admin.min'      => 'Alasan penolakan minimal 10 karakter.',
        ]);

        $payout = DB::table('jualan_kopi.payout_requests')
            ->where('id_request', $id)
            ->where('status', 'pending')
            ->first();

        if (!$payout) {
            return redirect()->back()->with('error', 'Pengajuan tidak ditemukan atau sudah diproses.');
        }

        DB::table('jualan_kopi.payout_requests')
            ->where('id_request', $id)
            ->update([
                'status'           => 'rejected',
                'keterangan_admin' => $request->keterangan_admin,
                'approved_by'      => $this->getAdminProfileId(),
                'reviewed_at'      => now(),
                'updated_at'       => now(),
            ]);

        return redirect()
            ->route('admin.payout.index')
            ->with('success', 'Pengajuan berhasil ditolak. Keterangan telah dikirim ke affiliate.');
    }

    // =========================================================
    // AFFILIATE SIDE
    // =========================================================

    /**
     * Form pengajuan & riwayat (Affiliate)
     */
    public function affiliateIndex()
    {
        $userId = Auth::id();

        $affiliate = DB::table('jualan_kopi.profiles as p')
            ->leftJoin('jualan_kopi.affiliate_profiles as ap', 'ap.profile_id', '=', 'p.id')
            ->select('p.*', 'ap.total_komisi', 'ap.minimum_payout', 'ap.kode_referal', 'ap.id_affiliate')
            ->where('p.user_id', $userId)
            ->first();

        if (!$affiliate) {
            abort(403, 'Anda bukan affiliate terdaftar.');
        }

        // Cek apakah ada pengajuan pending
        $pendingRequest = DB::table('jualan_kopi.payout_requests')
            ->where('id_affiliate', $affiliate->id)
            ->where('status', 'pending')
            ->first();

        // Riwayat pengajuan
        $payoutHistory = DB::table('jualan_kopi.payout_requests')
            ->where('id_affiliate', $affiliate->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages_admin.affiliate_payout_form', compact('affiliate', 'pendingRequest', 'payoutHistory'));
    }

    /**
     * Simpan pengajuan baru (Affiliate)
     */
    public function affiliateStore(Request $request)
    {
        $userId = Auth::id();

        $affiliate = DB::table('jualan_kopi.profiles as p')
            ->leftJoin('jualan_kopi.affiliate_profiles as ap', 'ap.profile_id', '=', 'p.id')
            ->select('p.*', 'ap.total_komisi', 'ap.minimum_payout')
            ->where('p.user_id', $userId)
            ->first();

        if (!$affiliate) {
            return redirect()->back()->with('error', 'Akun affiliate tidak ditemukan.');
        }

        // Validasi
        $minPayout = $affiliate->minimum_payout ?? 100000;
        $maxPayout = $affiliate->total_komisi ?? 0;

        $request->validate([
            'jumlah'          => "required|numeric|min:{$minPayout}|max:{$maxPayout}",
            'nama_bank'       => 'required|string|max:100',
            'nomor_rekening'  => 'required|string|max:50|regex:/^[0-9\-]+$/',
            'nama_pemilik_rek'=> 'required|string|max:200',
        ], [
            'jumlah.min'           => "Jumlah minimal pencairan adalah Rp " . number_format($minPayout, 0, ',', '.'),
            'jumlah.max'           => "Jumlah melebihi saldo komisi Anda.",
            'nomor_rekening.regex' => 'Nomor rekening hanya boleh berisi angka.',
        ]);

        // Cek tidak ada pending
        $hasPending = DB::table('jualan_kopi.payout_requests')
            ->where('id_affiliate', $affiliate->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            return redirect()->back()->with('error', 'Anda masih memiliki pengajuan yang sedang diproses. Tunggu hasilnya terlebih dahulu.');
        }

        // Simpan
        DB::table('jualan_kopi.payout_requests')->insert([
            'id_request'       => \Illuminate\Support\Str::uuid(),
            'id_affiliate'     => $affiliate->id,
            'jumlah'           => $request->jumlah,
            'nama_bank'        => $request->nama_bank,
            'nomor_rekening'   => $request->nomor_rekening,
            'nama_pemilik_rek' => $request->nama_pemilik_rek,
            'status'           => 'pending',
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        return redirect()
            ->route('affiliate.payout.index')
            ->with('success', 'Pengajuan pencairan komisi berhasil dikirim! Admin akan memproses dalam 1–3 hari kerja.');
    }


/**
 * Dashboard affiliate (ringkasan komisi)
 */
public function affiliateDashboard()
{
    $userId = Auth::id();
    
    $affiliate = DB::table('jualan_kopi.profiles as p')
        ->leftJoin('jualan_kopi.affiliate_profiles as ap', 'ap.profile_id', '=', 'p.id')
        ->select('p.*', 'ap.total_komisi', 'ap.minimum_payout', 'ap.kode_referal', 'ap.id_affiliate')
        ->where('p.user_id', $userId)
        ->first();
    
    if (!$affiliate) {
        abort(403, 'Anda bukan affiliate terdaftar.');
    }
    
    // Statistik komisi
    $stats = DB::table('jualan_kopi.komisi_histori')
        ->where('id_affiliate', $affiliate->id_affiliate)
        ->selectRaw('
            COUNT(*) as total_transaksi,
            SUM(jumlah_komisi) as total_komisi_dihasilkan,
            DATE_TRUNC(\'month\', created_at) as bulan
        ')
        ->groupBy('bulan')
        ->orderBy('bulan', 'desc')
        ->limit(6)
        ->get();
    
    // Pengajuan terakhir
    $lastRequest = DB::table('jualan_kopi.payout_requests')
        ->where('id_affiliate', $affiliate->id)
        ->orderBy('created_at', 'desc')
        ->first();
    
    return view('pages_admin.affiliate_dashboard', compact('affiliate', 'stats', 'lastRequest'));
}

/**
 * Halaman daftar komisi affiliate
 */
public function affiliateKomisi()
{
    $userId = Auth::id();
    
    $affiliate = DB::table('jualan_kopi.profiles as p')
        ->leftJoin('jualan_kopi.affiliate_profiles as ap', 'ap.profile_id', '=', 'p.id')
        ->select('p.*', 'ap.total_komisi', 'ap.minimum_payout', 'ap.kode_referal', 'ap.id_affiliate')
        ->where('p.user_id', $userId)
        ->first();
    
    if (!$affiliate) {
        abort(403, 'Anda bukan affiliate terdaftar.');
    }
    
    // Histori komisi
    $komisiHistori = DB::table('jualan_kopi.komisi_histori as kh')
        ->join('jualan_kopi.transaksi as t', 't.id_transaksi', '=', 'kh.id_transaksi')
        ->select('kh.*', 't.no_invoice', 't.created_at as transaksi_date')
        ->where('kh.id_affiliate', $affiliate->id_affiliate)
        ->orderBy('kh.created_at', 'desc')
        ->paginate(20);
    
    // Riwayat payout
    $payoutHistory = DB::table('jualan_kopi.payout_requests')
        ->where('id_affiliate', $affiliate->id)
        ->orderBy('created_at', 'desc')
        ->get();
    
    return view('pages_admin.affiliate_komisi', compact('affiliate', 'komisiHistori', 'payoutHistory'));
}

    // =========================================================
    // HELPER
    // =========================================================

    private function getAdminProfileId(): ?string
    {
        $userId = Auth::id();
        $admin = DB::table('jualan_kopi.admin_profiles as ap')
            ->join('jualan_kopi.profiles as p', 'p.id', '=', 'ap.profile_id')
            ->where('p.user_id', $userId)
            ->select('ap.id_admin')
            ->first();

        return $admin?->id_admin;
    }
}