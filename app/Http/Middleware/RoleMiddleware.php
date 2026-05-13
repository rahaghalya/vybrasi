<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Wajib dipanggil untuk ngecek tabel

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // 1. Pastikan user sudah login terlebih dahulu
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        // 2. Cek izin untuk rute Admin
        if ($role === 'admin') {
            $isAdmin = DB::table('admin_profiles')->where('profile_id', $user->id)->exists();
            if (!$isAdmin) {
                return redirect('/')->with('error', 'Akses ditolak! Anda bukan Admin.');
            }
        }

        // 3. Cek izin untuk rute Affiliate
        if ($role === 'affiliate') {
            $isAffiliate = DB::table('affiliate_profiles')->where('profile_id', $user->id)->exists();
            if (!$isAffiliate) {
                return redirect('/')->with('error', 'Akses ditolak! Anda bukan Affiliate.');
            }
        }

        return $next($request);
    }
}