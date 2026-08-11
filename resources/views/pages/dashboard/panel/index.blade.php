{{--
    Path: resources/views/pages/dashboard/panel/index.blade.php
    Route: GET /dashboard/panel -> homeController@panel (role:panel)
--}}
@extends('template.dashboard.layout')
@section('title', 'Panel Map of Feelings')

@section('body')
    <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Kelola Konten</p>
    <h1 class="text-3xl font-bold mb-8">Panel Map of Feelings</h1>

    <div class="space-y-3">
        @foreach ($moods as $mood)
            <div class="flex items-center gap-4 rounded-3xl bg-neutral-900 border border-white/10 p-5">
                <span class="w-10 h-10 rounded-full shrink-0" style="background: {{ $mood->color_primary }}"></span>

                <div class="flex-1 min-w-0">
                    <p class="font-bold truncate">{{ $mood->feeling }}</p>
                    <p class="text-xs text-white/40 truncate">{{ $mood->song }} &middot; {{ $mood->coordinate }}</p>
                </div>

                <a href="{{ route('dashboard.panel.edit', $mood) }}"
                    class="rounded-full border border-white/20 px-4 py-2 text-xs font-bold hover:bg-white/10 transition-colors shrink-0">Edit</a>
            </div>
        @endforeach
    </div>
@endsection
