<?php

namespace App\Http\Controllers;

use App\Models\pressconGuest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class pressconGuestController extends Controller
{
    /**
     * Daftar kategori tetap — dipakai buat dropdown & validasi. Kalau kategori
     * baru ditambah, cukup update array ini + enum di migration.
     */
    private const CATEGORIES = [
        'Crew',
        'Media',
        'Partner',
        'Venue',
        'Colleague',
        'DJ/Musician Colleague',
        'Artist/Production Team',
        'Inner Circle',
    ];

    // ===== Admin: CRUD tamu (semua di bawah middleware role:admin) =====

    /**
     * GET /dashboard/tamu
     */
    public function index(Request $request): View
    {
        $guests = pressconGuest::query()
            ->when($request->filled('search'), fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->filled('category'), fn($q) => $q->where('category', $request->category))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('pages.dashboard.tamu.index', [
            'guests' => $guests,
            'categories' => self::CATEGORIES,
            'active' => 'tamu',
        ]);
    }

    /**
     * GET /dashboard/tamu/create
     */
    public function create(): View
    {
        return view('pages.dashboard.tamu.create', [
            'categories' => self::CATEGORIES,
            'active' => 'tambah',
        ]);
    }

    /**
     * POST /dashboard/tamu
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:' . implode(',', self::CATEGORIES)],
            'group' => ['nullable', 'string', 'max:255'],
            'max_pax' => ['required', 'integer', 'min:1'],
            'details' => ['nullable', 'string', 'max:2000'],
        ]);

        $guest = pressconGuest::create([
            ...$validated,
            'slug' => pressconGuest::generateSlug($validated['name'], $validated['category']),
            'requires_name' => $request->boolean('requires_name'),
        ]);

        return redirect()
            ->route('dashboard.tamu')
            ->with('status', $guest->name . ' berhasil ditambahkan.');
    }

    /**
     * GET /dashboard/tamu/{guest}/edit
     */
    public function edit(pressconGuest $guest): View
    {
        return view('pages.dashboard.tamu.edit', [
            'guest' => $guest,
            'categories' => self::CATEGORIES,
            'active' => 'tamu',
        ]);
    }

    /**
     * PUT /dashboard/tamu/{guest}
     */
    public function update(Request $request, pressconGuest $guest): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:' . implode(',', self::CATEGORIES)],
            'group' => ['nullable', 'string', 'max:255'],
            'max_pax' => ['required', 'integer', 'min:1'],
            'details' => ['nullable', 'string', 'max:2000'],
        ]);

        $guest->update([
            ...$validated,
            'requires_name' => $request->boolean('requires_name'),
        ]);

        return redirect()
            ->route('dashboard.tamu')
            ->with('status', 'Data ' . $guest->name . ' berhasil diperbarui.');
    }

    /**
     * DELETE /dashboard/tamu/{guest}
     */
    public function destroy(pressconGuest $guest): RedirectResponse
    {
        $name = $guest->name;
        $guest->delete();

        return redirect()
            ->route('dashboard.tamu')
            ->with('status', $name . ' berhasil dihapus.');
    }
 
    // ===== Halaman publik (guest page) =====

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