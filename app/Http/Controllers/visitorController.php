<?php

namespace App\Http\Controllers;

use App\Models\mood_submissions;
use App\Models\visitorLog;
use Illuminate\View\View;

/**
 * Route: prefix /dashboard/pengunjung (role:admin)
 * Tab "Kunjungan" -> visitor_logs (semua pengunjung publik)
 * Tab "Download"  -> mood_submissions (pengunjung yang submit form & download PNG)
 */
class visitorController extends Controller
{
    /**
     * GET /dashboard/pengunjung
     */
    public function index(): View
    {
        return view('pages.dashboard.pengunjung.index', [
            'active' => 'pengunjung',
            'totalVisitors' => visitorLog::count(),
            'onlineNow' => visitorLog::onlineNow()->count(),
            'visitors' => visitorLog::latest('updated_at')->limit(100)->get(),
        ]);
    }

    /**
     * GET /dashboard/pengunjung/download
     */
    public function download(): View
    {
        return view('pages.dashboard.pengunjung.download', [
            'active' => 'pengunjung',
            'totalDownloads' => mood_submissions::count(),
            'submissions' => mood_submissions::with('mood')->latest('created_at')->limit(100)->get(),
        ]);
    }
}