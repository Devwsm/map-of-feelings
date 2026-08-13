<?php

namespace App\Http\Controllers;

use App\Models\mood;
use App\Models\mood_submissions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class homeController extends Controller
{
    /**
     * GET /
     */
    public function home(): View
    {
        $moods = mood::orderBy('sort_order')->get();
        return view('pages.home', ['moods' => $moods]);
    }

    /**
     * GET /dashboard/panel (role:panel)
     */
    public function panel(): View
    {
        $moods = mood::orderBy('sort_order')->get();
        return view('pages.dashboard.panel.index', [
            'moods' => $moods,
            'active' => 'panel',
        ]);
    }

    /**
     * POST /coordinate
     */
    public function storeCoordinate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'mood_key' => ['required', 'string', 'exists:moods,mood_key'],
            'visitor_name' => ['nullable', 'string', 'max:100'],
            'visitor_instagram' => ['nullable', 'string', 'max:100'],
            'selected_answer' => ['nullable', 'string', 'max:255'],
        ]);

        $mood = mood::where('mood_key', $validated['mood_key'])->firstOrFail();
        $mood->submissions()->create([
            'visitor_name' => $validated['visitor_name'] ?? null,
            'visitor_instagram' => $validated['visitor_instagram'] ?? null,
            'selected_answer' => $validated['selected_answer'] ?? null,
            'ip_address' => $request->ip(),
            'created_at' => now(),
        ]);

        return response()->json(['status' => 'ok']);
    }

    /**
     * GET /dashboard/panel/submissions (role:panel,admin)
     */
    public function submissions(Request $request): View
    {
        $moods = mood::orderBy('sort_order')->get();
        $query = mood_submissions::with('mood')->latest('created_at');

        if ($request->filled('mood')) {
            $query->whereHas('mood', fn($q) => $q->where('mood_key', $request->string('mood')));
        }

        $submissions = $query->paginate(20)->withQueryString();
        $summary = mood_submissions::selectRaw('mood_id, count(*) as total')
            ->groupBy('mood_id')
            ->with('mood')
            ->get()
            ->sortByDesc('total');

        return view('pages.dashboard.panel.submissions', [
            'moods' => $moods,
            'submissions' => $submissions,
            'summary' => $summary,
            'selectedMood' => $request->string('mood')->toString(),
            'active' => 'panel-submissions',
        ]);
    }

    /**
     * GET /dashboard/panel/{mood}/edit (role:panel)
     */
    public function editPanel(mood $mood): View
    {
        return view('pages.dashboard.panel.edit', [
            'mood' => $mood,
            'active' => 'panel',
        ]);
    }

    /**
     * PUT /dashboard/panel/{mood} (role:panel)
     */
    public function updatePanel(Request $request, mood $mood): RedirectResponse
    {
        $validated = $request->validate([
            'feeling' => ['required', 'string', 'max:255'],
            'nuance' => ['required', 'string', 'max:255'],
            'song' => ['required', 'string', 'max:255'],
            'question' => ['required', 'string'],
            'choice_1' => ['required', 'string', 'max:255'],
            'choice_2' => ['required', 'string', 'max:255'],
            'choice_3' => ['required', 'string', 'max:255'],
            'choice_4' => ['required', 'string', 'max:255'],
            'answer' => ['nullable', 'string'],
            'coordinate' => ['required', 'string', 'max:255'],
            'why' => ['required', 'string'],
            'affirmation' => ['required', 'string'],
            'weather_text' => ['nullable', 'string', 'max:255'],
            'artwork_path' => ['nullable', 'string', 'max:255'],
            'audio_path' => ['nullable', 'string', 'max:255'],
            'color_primary' => ['required', 'string', 'max:7'],
            'color_secondary' => ['required', 'string', 'max:7'],
            'color_accent' => ['required', 'string', 'max:7'],
            'color_text' => ['required', 'string', 'max:7'],
            'mof_url' => ['nullable', 'string', 'max:255'],
        ]);

        $mood->update($validated);

        return redirect()
            ->route('dashboard.panel')
            ->with('status', $mood->feeling . ' berhasil diperbarui.');
    }
}