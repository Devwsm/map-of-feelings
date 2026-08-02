<?php

namespace App\Http\Controllers;

use App\Models\pressconGuest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class checkinController extends Controller
{
    /**
     * GET /dashboard/checkin
     */
    public function index(): View
    {
        $totalGuests = pressconGuest::count();
        $checkedInCount = pressconGuest::where('checked_in', true)->count();
        $recent = pressconGuest::where('checked_in', true)
            ->with('checkedInBy')
            ->orderByDesc('arrival_time')
            ->limit(10)
            ->get();

        return view('pages.dashboard.checkin', [
            'active' => 'checkin',
            'totalGuests' => $totalGuests,
            'checkedInCount' => $checkedInCount,
            'recent' => $recent,
        ]);
    }

    /**
     * GET /dashboard/checkin/search?q=...
     * Dipanggil AJAX dari dropdown pencarian.
     */
    public function search(Request $request): JsonResponse
    {
        $query = trim((string) $request->get('q'));
        if ($query === '') {
            return response()->json([]);
        }

        $guests = pressconGuest::query()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('submitted_name', 'like', "%{$query}%")
                    ->orWhere('slug', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id_guest', 'slug', 'name', 'submitted_name', 'category', 'checked_in']);

        return response()->json($guests->map(fn($guest) => [
            'slug' => $guest->slug,
            'label' => $guest->submitted_name ?: $guest->name,
            'category' => $guest->category,
            'checked_in' => $guest->checked_in,
        ]));
    }

    /**
     * POST /dashboard/checkin/{guest}
     * Row-locked, biar 2 staff yang nge-hit tamu yang sama nyaris bersamaan gak dobel proses.
     */
    public function store(pressconGuest $guest): JsonResponse
    {
        return DB::transaction(function () use ($guest) {
            $locked = pressconGuest::where('id_guest', $guest->id_guest)
                ->lockForUpdate()
                ->first();

            if ($locked->checked_in) {
                $locked->load('checkedInBy');
                return response()->json([
                    'status' => 'already',
                    'message' => sprintf(
                        'Sudah check-in jam %s%s.',
                        optional($locked->arrival_time)->format('H:i'),
                        $locked->checkedInBy ? " oleh {$locked->checkedInBy->name}" : ''
                    ),
                ]);
            }

            $locked->update([
                'checked_in' => true,
                'arrival_time' => now(),
                'checked_in_by' => Auth::id(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => ($locked->submitted_name ?: $locked->name) . ' berhasil check-in.',
                'name' => $locked->submitted_name ?: $locked->name,
                'time' => $locked->arrival_time->format('H:i'),
            ]);
        });
    }
}