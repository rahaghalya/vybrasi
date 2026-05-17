<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        
        // Mengambil alamat utama pengguna (jika ada)
        $alamat = DB::table('jualan_kopi.alamat_pengiriman')
                    ->where('user_id', $user->id)
                    ->orderBy('is_primary', 'desc') // Mengutamakan yang is_primary = true
                    ->first();

        // Mengirimkan data user dan alamat ke view
        return view('pages.edit-profil', compact('alamat'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // 1. Validasi Input Profil & Alamat
        $request->validate([
            'full_name'      => 'required|string|max:255',
            'username'       => 'required|string|max:255|unique:pgsql.jualan_kopi.profiles,username,' . $user->id . ',id',
            'email'          => 'required|email|max:255|unique:pgsql.jualan_kopi.profiles,email,' . $user->id . ',id',
            'phone'          => 'nullable|string|max:20',
            'tanggal_lahir'  => 'nullable|date',
            // Validasi Alamat
            'alamat_lengkap' => 'nullable|string',
            'provinsi'       => 'nullable|string|max:255',
            'kota'           => 'nullable|string|max:255',
            'kode_pos'       => 'nullable|string|max:20',
            // Validasi Password
            'old_password'   => 'nullable|string',
            'password'       => 'nullable|string|min:8|confirmed',
        ]);

        // 2. Update Data Dasar Profil
        $user->full_name     = $request->full_name;
        $user->username      = $request->username;
        $user->email         = $request->email;
        $user->phone         = $request->phone;
        $user->tanggal_lahir = $request->tanggal_lahir;

        // 3. Logika Simpan/Update Alamat Pengiriman
        if ($request->filled('alamat_lengkap')) {
            // Cek apakah user sudah punya alamat
            $existingAlamat = DB::table('jualan_kopi.alamat_pengiriman')
                                ->where('user_id', $user->id)
                                ->first();

            if ($existingAlamat) {
                // Update alamat yang sudah ada
                DB::table('jualan_kopi.alamat_pengiriman')
                    ->where('id_alamat', $existingAlamat->id_alamat)
                    ->update([
                        'penerima'       => $request->full_name,
                        'no_telepon'     => $request->phone,
                        'alamat_lengkap' => $request->alamat_lengkap,
                        'provinsi'       => $request->provinsi,
                        'kota'           => $request->kota,
                        'kode_pos'       => $request->kode_pos,
                        'updated_at'     => now(),
                    ]);
            } else {
                // Buat alamat baru jika belum pernah ada
                DB::table('jualan_kopi.alamat_pengiriman')->insert([
                    'id_alamat'      => Str::uuid(),
                    'user_id'        => $user->id,
                    'label_alamat'   => 'Rumah',
                    'penerima'       => $request->full_name,
                    'no_telepon'     => $request->phone ?? '-',
                    'alamat_lengkap' => $request->alamat_lengkap,
                    'provinsi'       => $request->provinsi,
                    'kota'           => $request->kota,
                    'kode_pos'       => $request->kode_pos,
                    'is_primary'     => true,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

        // 4. Logika Ganti Password
        if ($request->filled('old_password') || $request->filled('password')) {
            
            if (!$request->filled('old_password')) {
                return back()->withErrors(['old_password' => 'Anda harus memasukkan password lama untuk mengubah password.']);
            }

            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Password lama yang Anda masukkan salah.']);
            }

            $oldPasswordHash = $user->password;
            
            // Ganti password
            $user->password = Hash::make($request->password);

            try {
                DB::table('jualan_kopi.password_history')->insert([
                    'id_history'        => Str::uuid(),
                    'user_id'           => $user->id, 
                    'old_password_hash' => $oldPasswordHash,
                    'changed_by'        => $user->id, 
                    'ip_address'        => $request->ip(),
                    'user_agent'        => $request->userAgent(),
                    'changed_at'        => now(),
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal mencatat password history: ' . $e->getMessage());
            }
        }

        // 5. Simpan ke database profiles
        $user->save();

        return back()->with('success', 'Profil dan alamat berhasil diperbarui!');
    }
}