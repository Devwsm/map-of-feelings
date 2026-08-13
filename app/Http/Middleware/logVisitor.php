<?php

namespace App\Http\Middleware;

use App\Models\visitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dipasang global di grup 'web' (lihat bootstrap/app.php).
 * Nyatet 1 baris per session ke tabel visitor_logs — kunjungan baru bikin row baru,
 * kunjungan ulang (session sama) cuma nge-update updated_at (last_seen) & url terakhir.
 *
 * Sengaja di-skip untuk: request non-GET, request AJAX/JSON, asset statis, dan
 * semua halaman /dashboard/* & /login biar data yang kecatat murni pengunjung publik,
 * bukan aktivitas admin/staff pas kerja.
 */
class logVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        try {
            visitorLog::updateOrCreate(
                ['session_id' => $request->session()->getId()],
                [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'browser' => $this->detectBrowser($request->userAgent()),
                    'platform' => $this->detectPlatform($request->userAgent()),
                    'device_type' => $this->detectDeviceType($request->userAgent()),
                    'url' => $request->path() === '/' ? '/' : '/' . $request->path(),
                    'referer' => $request->headers->get('referer'),
                ]
            );
        } catch (\Throwable $e) {
            // Logging kunjungan gak boleh sampai bikin halaman utama down kalau ada error DB.
            report($e);
        }

        return $next($request);
    }

    protected function shouldSkip(Request $request): bool
    {
        if (! $request->isMethod('get')) {
            return true;
        }

        if ($request->ajax() || $request->wantsJson()) {
            return true;
        }

        if ($request->is('dashboard*')) {
            return true;
        }

        // Asset statis / file, bukan halaman
        if (preg_match('/\.(css|js|map|png|jpe?g|gif|webp|svg|ico|woff2?|ttf|mp3|mp4|json|xml|txt)$/i', $request->path())) {
            return true;
        }

        return false;
    }

    protected function detectBrowser(?string $ua): ?string
    {
        if (! $ua) return null;

        return match (true) {
            str_contains($ua, 'Edg/') => 'Edge',
            str_contains($ua, 'OPR/') || str_contains($ua, 'Opera') => 'Opera',
            str_contains($ua, 'Chrome/') && ! str_contains($ua, 'Chromium') => 'Chrome',
            str_contains($ua, 'CriOS') => 'Chrome (iOS)',
            str_contains($ua, 'FxiOS') => 'Firefox (iOS)',
            str_contains($ua, 'Firefox/') => 'Firefox',
            str_contains($ua, 'Safari/') && str_contains($ua, 'Version/') => 'Safari',
            default => 'Lainnya',
        };
    }

    protected function detectPlatform(?string $ua): ?string
    {
        if (! $ua) return null;

        return match (true) {
            str_contains($ua, 'Windows') => 'Windows',
            str_contains($ua, 'iPhone') || str_contains($ua, 'iPad') || str_contains($ua, 'iOS') => 'iOS',
            str_contains($ua, 'Mac OS X') => 'macOS',
            str_contains($ua, 'Android') => 'Android',
            str_contains($ua, 'Linux') => 'Linux',
            default => 'Lainnya',
        };
    }

    protected function detectDeviceType(?string $ua): string
    {
        if (! $ua) return 'desktop';

        if (str_contains($ua, 'iPad') || (str_contains($ua, 'Android') && ! str_contains($ua, 'Mobile'))) {
            return 'tablet';
        }

        if (str_contains($ua, 'Mobi') || str_contains($ua, 'iPhone') || str_contains($ua, 'Android')) {
            return 'mobile';
        }

        return 'desktop';
    }
}