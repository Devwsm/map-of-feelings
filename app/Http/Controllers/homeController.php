<?php

namespace App\Http\Controllers;

use App\Models\mood;
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