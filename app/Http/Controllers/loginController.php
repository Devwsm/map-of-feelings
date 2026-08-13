<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class loginController extends Controller
{
    // Maksimal percobaan login gagal sebelum di-lock sementara.
    protected const MAX_ATTEMPTS = 5;
    // Lama lock dalam detik setelah kena limit.
    protected const DECAY_SECONDS = 180;

    /**
     * GET /login
     */
    public function create(): View
    {
        return view('pages.login');
    }

    /**
     * POST /login
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = $this->throttleKey($request);

        // Kalau sesi email+IP ini udah kena limit, tolak duluan tanpa cek password
        // sama sekali — biar percobaan brute-force gak lanjut ngetes password lain.
        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withErrors(['email' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik."])
                ->onlyInput('email');
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey, self::DECAY_SECONDS);
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        // Login berhasil, reset hitungan percobaan gagal buat kombinasi ini.
        RateLimiter::clear($throttleKey);

        $request->session()->regenerate();
        $redirect = match ($request->user()->role) {
            'panel' => route('dashboard.panel'),
            default => route('dashboard'),
        };

        return redirect()->intended($redirect);
    }

    /**
     * POST /logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Key unik per kombinasi email + IP, biar orang lain di IP yang sama
     * (misal satu kantor/wifi) gak ikut ke-lock gara-gara ada yang salah input.
     */
    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email', '')) . '|' . $request->ip();
    }
}