{{--
    Path: resources/views/pages/dashboard.blade.php
    Route: GET /dashboard -> dashboardController@index, dilindungi middleware('auth').
--}}
@extends('template.dashboard.layout')
@section('title', 'Press Conference Dashboard')

@section('body')
    <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Selamat datang kembali</p>
    <h1 class="text-3xl font-bold mb-8">Halo, {{ auth()->user()->name }} 👋</h1>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-10">
        <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6">
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-3">Total Undangan</p>
            <p class="font-mono text-4xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6">
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-3">Tidak Hadir</p>
            <p class="font-mono text-4xl font-bold">{{ $stats['tidak_hadir'] }}</p>
        </div>
        <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6">
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-3">Checked In</p>
            <p class="font-mono text-4xl font-bold">{{ $stats['checked_in'] }}</p>
        </div>
        <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6">
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-3">Belum Respons</p>
            <p class="font-mono text-4xl font-bold">{{ $stats['belum_respons'] }}</p>
        </div>
    </div>

    {{-- CATEGORY TICKER --}}
    <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-3">Kategori</p>
    <div class="flex gap-3 overflow-x-auto pb-2 mb-10">
        @foreach (['Crew', 'Media', 'Partner', 'Venue', 'Colleague', 'DJ/Musician Colleague', 'Artist/Production Team', 'Inner Circle'] as $category)
            <span
                class="flex items-center gap-2 rounded-full border border-white/10 bg-neutral-900 px-4 py-2 text-sm whitespace-nowrap">
                <span class="w-2 h-2 rounded-full {{ \App\Models\pressconGuest::categoryColor($category) }}"></span>
                {{ $category }}
                <span class="font-mono text-white/50">{{ $categoryCounts->get($category, 0) }}</span>
            </span>
        @endforeach
    </div>

    {{-- EMPTY STATE --}}
    <div class="rounded-3xl border border-dashed border-white/15 p-10 text-center">
        <p class="font-bold mb-1">Belum ada aktivitas (belum sinkron data)</p>
        <p class="text-sm text-white/50">RSVP dan check-in tamu bakal muncul di sini begitu mulai masuk.</p>
    </div>
@endsection
