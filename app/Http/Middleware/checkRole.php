<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dipakai lewat alias 'role', contoh di routes/web.php:
 *   Route::middleware('role:admin')->group(...)          -> cuma admin
 *   Route::middleware('role:admin,staff')->group(...)     -> admin & staff berdua boleh
 *
 * Middleware ini jalan SETELAH 'auth' (harus urut di route group), jadi $request->user()
 * dijamin udah ada, gak perlu dicek null lagi — tapi tetep dicek buat jaga-jaga.
 */
class checkRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        if (! $user || ! in_array($user->role, $roles, true)) {
            abort(403, 'Kamu gak punya akses ke halaman ini.');
        }
        return $next($request);
    }
}