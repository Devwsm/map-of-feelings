<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class loginController extends Controller
{
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

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

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
}