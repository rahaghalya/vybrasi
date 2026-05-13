<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    // ==========================================
    // FITUR LOGIN
    // ==========================================
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function prosesLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            return redirect()->route('login')->with('error_popup', 'Login gagal! Anda telah diblokir sementara, silakan tunggu 24 jam.');
        }

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.beranda');
            }

            return redirect()->route('beranda');
        }

        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // ==========================================
    // FITUR DAFTAR (REGISTRASI)
    // ==========================================
    public function showDaftarForm()
    {
        return view('auth.daftar');
    }

    public function prosesDaftar(Request $request)
    {
        // 1. Validasi format (tanpa unique — dicek manual di bawah)
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'ends_with:@gmail.com'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.ends_with'    => 'Mohon gunakan email yang berakhiran @gmail.com',
            'password.confirmed' => 'Konfirmasi password tidak cocok dengan password yang dimasukkan.',
            'password.min'       => 'Password minimal harus 8 karakter.',
        ]);

        // 2. Cek email unik secara manual ke tabel profiles (search_path sudah jualan_kopi)
        $emailSudahAda = DB::table('profiles')
            ->where('email', strtolower($request->email))
            ->exists();

        if ($emailSudahAda) {
            return back()
                ->withErrors(['email' => 'Email ini sudah terdaftar di sistem kami.'])
                ->onlyInput('name', 'email');
        }

        // 3. Generate username otomatis
        $generatedUsername = Str::before($request->email, '@') . '_' . Str::random(4);

        // 4. Simpan ke database
        User::create([
            'full_name' => $request->name,
            'username'  => $generatedUsername,
            'email'     => strtolower($request->email),
            'password'  => Hash::make($request->password),
            'role'      => 'user',
            'can_shop'  => true,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login menggunakan akun Gmail Anda.');
    }

    // ==========================================
    // FITUR LOGOUT
    // ==========================================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}