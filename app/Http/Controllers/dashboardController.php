<?php

namespace App\Http\Controllers;

use App\Models\pressconGuest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class dashboardController extends Controller
{
    /**
     * GET /dashboard
     * Route ini wajib dibungkus middleware('auth') di web.php.
     */
    public function index(): View
    {
        $stats = [
            'total' => pressconGuest::count(),
            'tidak_hadir' => pressconGuest::where('rsvp_status', 'tidak_hadir')->count(),
            'checked_in' => pressconGuest::where('checked_in', true)->count(),
            'belum_respons' => pressconGuest::where('rsvp_status', 'pending')->where('checked_in', false)->count(),
        ];
        $categoryCounts = pressconGuest::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        // Aktivitas terbaru: tamu yang udah RSVP (bukan pending) atau udah check-in,
        // diurut dari yang paling baru diupdate. Ini yang isi "Recent Activity"
        // di dashboard home, gantiin empty state statis yang lama.
        $recentActivity = pressconGuest::with('checkedInBy')
            ->where(function ($query) {
                $query->where('checked_in', true)
                    ->orWhere('rsvp_status', '!=', 'pending');
            })
            ->orderByDesc('updated_at')
            ->limit(8)
            ->get();

        return view('pages.dashboard', [
            'stats' => $stats,
            'categoryCounts' => $categoryCounts,
            'recentActivity' => $recentActivity,
            'active' => 'home',
        ]);
    }
}