<?php

namespace App\Http\Controllers;

use App\Models\pressconGuest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        if ($guest->qr_path) {
            Storage::disk('public')->delete($guest->qr_path);
        }

        $guest->delete();

        return redirect()
            ->route('dashboard.tamu')
            ->with('status', $name . ' berhasil dihapus.');
    }

    /**
     * POST /dashboard/tamu/generate-qr-bulk
     * Generate QR buat SEMUA tamu yang belum punya QR sekaligus (dipakai abis
     * import massal, misal 200 tamu, biar gak perlu klik generate satu-satu).
     * Masih sinkron (bukan queue) karena tiap QR-nya ringan (SVG, gak butuh
     * Imagick/GD) — generate ratusan QR biasanya tetap kelar dalam hitungan
     * detik. set_time_limit dinaikkan jaga-jaga kalau datanya makin banyak ke
     * depannya dan default PHP time limit di hosting kepotong duluan.
     */
    public function generateQrBulk(): RedirectResponse
    {
        set_time_limit(180);

        $guests = pressconGuest::where('qr_generated', false)
            ->orWhereNull('qr_path')
            ->get();

        foreach ($guests as $guest) {
            if ($guest->qr_path) {
                Storage::disk('public')->delete($guest->qr_path);
            }

            $filename = 'qrcodes/' . Str::random(40) . '.svg';
            $svg = QrCode::format('svg')->size(400)->generate($guest->slug);

            Storage::disk('public')->put($filename, $svg);

            $guest->update([
                'qr_path' => $filename,
                'qr_generated' => true,
            ]);
        }

        return redirect()
            ->back()
            ->with('status', 'QR berhasil digenerate untuk ' . $guests->count() . ' tamu.');
    }

    /**
     * POST /dashboard/tamu/{guest}/generate-qr
     * Isi QR = check-in code (slug), nama file random & gak ketebak — beda dari
     * slug yang sengaja gampang dibaca manusia. Aman digenerate sinkron karena
     * cuma 1 tamu, cepat (beda kasus sama import massal yang butuh queue).
     */
    public function generateQr(pressconGuest $guest): RedirectResponse
    {
        if ($guest->qr_path) {
            Storage::disk('public')->delete($guest->qr_path);
        }

        $filename = 'qrcodes/' . Str::random(40) . '.svg';
        $svg = QrCode::format('svg')->size(400)->generate($guest->slug);

        Storage::disk('public')->put($filename, $svg);

        $guest->update([
            'qr_path' => $filename,
            'qr_generated' => true,
        ]);

        return redirect()
            ->back()
            ->with('status', 'QR untuk ' . $guest->name . ' berhasil digenerate.');
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