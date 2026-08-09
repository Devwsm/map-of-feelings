{{--
    Path: resources/views/pages/dashboard/panel/edit.blade.php
    Route: GET /dashboard/panel/{mood}/edit -> homeController@editPanel (role:panel)
--}}
@extends('template.dashboard.layout')
@section('title', 'Edit ' . $mood->feeling)

@section('body')
    <a href="{{ route('dashboard.panel') }}"
        class="text-xs font-bold uppercase tracking-widest text-white/40 hover:text-white/70 transition-colors">&larr;
        Kembali ke Panel</a>

    <h1 class="text-3xl font-bold mt-3 mb-8">Edit {{ $mood->feeling }}</h1>

    <form action="{{ route('dashboard.panel.update', $mood) }}" method="POST" class="max-w-2xl space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="feeling" class="block text-sm font-bold mb-2">Nama Perasaan</label>
                <input id="feeling" name="feeling" type="text" value="{{ old('feeling', $mood->feeling) }}" required
                    class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
                @error('feeling')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="song" class="block text-sm font-bold mb-2">Judul Lagu</label>
                <input id="song" name="song" type="text" value="{{ old('song', $mood->song) }}" required
                    class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
                @error('song')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="nuance" class="block text-sm font-bold mb-2">Deskripsi Kondisi Emosi</label>
            <input id="nuance" name="nuance" type="text" value="{{ old('nuance', $mood->nuance) }}" required
                class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
        </div>

        <div>
            <label for="question" class="block text-sm font-bold mb-2">Pertanyaan Refleksi</label>
            <textarea id="question" name="question" rows="2"
                class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40">{{ old('question', $mood->question) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            @for ($i = 1; $i <= 4; $i++)
                <div>
                    <label for="choice_{{ $i }}" class="block text-sm font-bold mb-2">Pilihan
                        {{ $i }}</label>
                    <textarea id="choice_{{ $i }}" name="choice_{{ $i }}" rows="2"
                        class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40">{{ old('choice_' . $i, $mood->{'choice_' . $i}) }}</textarea>
                </div>
            @endfor
        </div>

        <div>
            <label for="coordinate" class="block text-sm font-bold mb-2">Nama Koordinat</label>
            <input id="coordinate" name="coordinate" type="text" value="{{ old('coordinate', $mood->coordinate) }}"
                required
                class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
        </div>

        <div>
            <label for="why" class="block text-sm font-bold mb-2">Kenapa Lagu Ini?</label>
            <textarea id="why" name="why" rows="3"
                class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40">{{ old('why', $mood->why) }}</textarea>
        </div>

        <div>
            <label for="affirmation" class="block text-sm font-bold mb-2">Kalimat Penutup</label>
            <textarea id="affirmation" name="affirmation" rows="3"
                class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40">{{ old('affirmation', $mood->affirmation) }}</textarea>
        </div>

        <div>
            <label for="weather_text" class="block text-sm font-bold mb-2">Cuaca Atlas</label>
            <input id="weather_text" name="weather_text" type="text"
                value="{{ old('weather_text', $mood->weather_text) }}"
                class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="artwork_path" class="block text-sm font-bold mb-2">Path Artwork</label>
                <input id="artwork_path" name="artwork_path" type="text"
                    value="{{ old('artwork_path', $mood->artwork_path) }}" placeholder="assets/artwork/nama-file.svg"
                    class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
                <p class="mt-1 text-xs text-white/40">Relatif ke folder public/, file harus udah diupload manual.</p>
            </div>

            <div>
                <label for="audio_path" class="block text-sm font-bold mb-2">Path Audio Preview</label>
                <input id="audio_path" name="audio_path" type="text" value="{{ old('audio_path', $mood->audio_path) }}"
                    placeholder="assets/audio/nama-file.mp3"
                    class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
                <p class="mt-1 text-xs text-white/40">Relatif ke folder public/, file harus udah diupload manual.</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-5">
            <div>
                <label for="color_primary" class="block text-sm font-bold mb-2">Warna Utama</label>
                <input id="color_primary" name="color_primary" type="color"
                    value="{{ old('color_primary', $mood->color_primary) }}"
                    class="w-full h-12 rounded-2xl border border-white/15 bg-neutral-900 p-1" />
            </div>
            <div>
                <label for="color_secondary" class="block text-sm font-bold mb-2">Warna Tengah</label>
                <input id="color_secondary" name="color_secondary" type="color"
                    value="{{ old('color_secondary', $mood->color_secondary) }}"
                    class="w-full h-12 rounded-2xl border border-white/15 bg-neutral-900 p-1" />
            </div>
            <div>
                <label for="color_accent" class="block text-sm font-bold mb-2">Warna Aksen</label>
                <input id="color_accent" name="color_accent" type="color"
                    value="{{ old('color_accent', $mood->color_accent) }}"
                    class="w-full h-12 rounded-2xl border border-white/15 bg-neutral-900 p-1" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="spotify_url" class="block text-sm font-bold mb-2">Link Spotify</label>
                <input id="spotify_url" name="spotify_url" type="text"
                    value="{{ old('spotify_url', $mood->spotify_url) }}"
                    class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
            </div>
            <div>
                <label for="youtube_url" class="block text-sm font-bold mb-2">Link YouTube</label>
                <input id="youtube_url" name="youtube_url" type="text"
                    value="{{ old('youtube_url', $mood->youtube_url) }}"
                    class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
            </div>
        </div>

        <button type="submit"
            class="rounded-full bg-white text-black font-bold px-6 py-3 hover:bg-neutral-200 transition-colors">Simpan
            Perubahan</button>
    </form>
@endsection
