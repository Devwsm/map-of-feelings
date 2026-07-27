<?php

namespace App\Http\Controllers;

use App\Models\pressconGuest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class pressconGuestController extends Controller
{
    //
    /**
     * GET /presscon-inv/{guest}
     * Laravel otomatis nyari row berdasarkan kolom slug (lihat getRouteKeyName() di model).
     * Kalau slug gak ketemu, Laravel otomatis lempar 404 — gak perlu dicek manual.
     */
    public function show(pressconGuest $guest): View
    {
        return view('pages.presscon.guest', compact('guest'));
    }

    /**
     * POST /presscon-inv/{guest}/rsvp
     *
     * Satu route dipakai buat 3 aksi berbeda, dibedakan lewat hidden input "action":
     * - confirm_name : tamu koreksi/konfirmasi nama lengkap (gak ngubah rsvp_status)
     * - decline       : tamu declare "Tidak Hadir" (jadi satu-satunya self-report yang
     *                    diizinkan — "Hadir" itu ditentukan lewat check-in staff, bukan sini)
     * - cancel        : tamu batalin "Tidak Hadir" yang udah disubmit, balik ke pending
     */
    public function rsvp(Request $request, pressconGuest $guest): RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required', 'in:confirm_name,decline,cancel'],
            'submitted_name' => ['required_if:action,confirm_name', 'nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        match ($validated['action']) {
            'confirm_name' => $guest->update([
                'submitted_name' => $validated['submitted_name'],
            ]),
            'decline' => $guest->update([
                'rsvp_status' => 'tidak_hadir',
                'note' => $validated['note'] ?? null,
                'confirmed_pax' => 0,
            ]),
            'cancel' => $guest->update([
                'rsvp_status' => 'pending',
                'note' => null,
                'confirmed_pax' => null,
            ]),
        };

        return redirect()
            ->route('presscon-inv.guest', $guest->slug)
            ->with('rsvp_saved', $validated['action']);
    }
}