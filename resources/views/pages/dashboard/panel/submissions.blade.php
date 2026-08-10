{{--
    Path: resources/views/pages/dashboard/panel/submissions.blade.php
    Route: GET /dashboard/panel/submissions -> homeController@submissions (role:panel,admin)
--}}
@extends('template.dashboard.layout')
@section('title', 'Data Koordinat Tersimpan')

@section('body')
    <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Pendataan Lagu</p>
    <h1 class="text-3xl font-bold mb-8">Data Koordinat Tersimpan</h1>

    {{-- RINGKASAN PER LAGU --}}
    <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-3">Lagu Terpopuler</p>
    <div class="flex gap-3 overflow-x-auto pb-2 mb-10">
        @forelse ($summary as $row)
            <span
                class="flex items-center gap-2 rounded-full border border-white/10 bg-neutral-900 px-4 py-2 text-sm whitespace-nowrap">
                <span class="w-2 h-2 rounded-full" style="background: {{ $row->mood->color_primary }}"></span>
                {{ $row->mood->song }}
                <span class="font-mono text-white/50">{{ $row->total }}</span>
            </span>
        @empty
            <span class="text-sm text-white/40">Belum ada data.</span>
        @endforelse
    </div>

    {{-- FILTER --}}
    <form method="GET" class="mb-6 flex flex-wrap items-center gap-3">
        <label for="mood" class="text-xs font-bold uppercase tracking-widest text-white/40">Filter Lagu</label>
        <select id="mood" name="mood" onchange="this.form.submit()"
            class="rounded-full border border-white/15 bg-neutral-900 px-4 py-2 text-sm focus:outline-none focus:border-white/40">
            <option value="">Semua Lagu</option>
            @foreach ($moods as $mood)
                <option value="{{ $mood->mood_key }}" {{ $selectedMood === $mood->mood_key ? 'selected' : '' }}>
                    {{ $mood->song }}
                </option>
            @endforeach
        </select>

        @if ($selectedMood)
            <a href="{{ route('dashboard.panel.submissions') }}"
                class="text-xs font-bold uppercase tracking-widest text-white/40 hover:text-white/70">Reset</a>
        @endif
    </form>

    {{-- TABEL --}}
    @if ($submissions->isEmpty())
        <div class="rounded-3xl border border-dashed border-white/15 p-10 text-center">
            <p class="font-bold mb-1">Belum ada koordinat yang disimpan</p>
            <p class="text-sm text-white/50">Data bakal muncul di sini begitu ada pengunjung yang klik "Simpan Koordinat".
            </p>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($submissions as $item)
                <div class="flex items-center gap-4 rounded-3xl bg-neutral-900 border border-white/10 p-5">
                    <span class="w-10 h-10 rounded-full shrink-0"
                        style="background: {{ $item->mood->color_primary }}"></span>

                    <div class="flex-1 min-w-0">
                        <p class="font-bold truncate">{{ $item->mood->song }} &middot; {{ $item->mood->feeling }}</p>
                        <p class="text-xs text-white/40 truncate">
                            {{ $item->visitor_name ?: 'Tanpa nama' }}
                            @if ($item->visitor_instagram)
                                &middot; {{ $item->visitor_instagram }}
                            @endif
                        </p>
                        @if ($item->selected_answer)
                            <p class="text-xs text-white/30 truncate mt-1">"{{ $item->selected_answer }}"</p>
                        @endif
                    </div>

                    {{-- <p class="text-xs font-mono text-white/40 shrink-0">
                        {{ $item->created_at?->format('d M Y, H:i') }}
                    </p> --}}
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $submissions->links() }}
        </div>
    @endif
@endsection
