{{--
    Path: resources/views/pages/dashboard/import/index.blade.php
    Route: GET /dashboard/import -> importExportController@importIndex (role:admin)
--}}
@extends('template.dashboard.layout')
@section('title', 'Export / Import')

@section('body')
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Kelola Data</p>
        <h1 class="text-3xl font-bold">Import</h1>
    </div>

    {{-- TOGGLE EXPORT/IMPORT --}}
    <div class="flex gap-2 mb-6">
        <a href="{{ route('dashboard.export') }}"
            class="rounded-full border border-white/20 px-4 py-2 text-xs font-bold uppercase tracking-widest text-white/60 hover:bg-white/10 transition-colors">Export</a>
        <span class="rounded-full bg-white text-black px-4 py-2 text-xs font-bold uppercase tracking-widest">Import</span>
    </div>

    @if (session('status'))
        <div class="mb-6 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('importErrors') && count(session('importErrors')) > 0)
        <div class="mb-6 rounded-2xl border border-amber-500/30 bg-amber-500/10 px-4 py-3 text-sm text-amber-300">
            <p class="font-bold mb-2">{{ count(session('importErrors')) }} baris dilewati:</p>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
                @foreach (session('importErrors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- IMPORT TAMU --}}
    <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6">
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-6">
            <div>
                <p class="font-bold mb-1">Import Data Tamu</p>
                <p class="text-sm text-white/50">
                    Upload file Excel/CSV buat nambahin banyak tamu sekaligus. Total tamu saat ini
                    {{ $totalGuests }}.
                </p>
            </div>
            <a href="{{ route('dashboard.import.tamu.template') }}"
                class="shrink-0 rounded-full border border-white/20 px-5 py-3 text-sm font-bold hover:bg-white/10 transition-colors text-center">
                Download Template
            </a>
        </div>

        <form action="{{ route('dashboard.import.tamu') }}" method="POST" enctype="multipart/form-data"
            onsubmit="return confirm('Import file ini sekarang? Data yang valid bakal langsung ditambahkan.');"
            class="flex flex-col sm:flex-row gap-3">
            @csrf
            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                class="flex-1 rounded-2xl border border-white/15 bg-neutral-950 px-4 py-3 text-sm file:mr-4 file:rounded-full file:border-0 file:bg-white file:text-black file:px-4 file:py-2 file:text-xs file:font-bold file:uppercase file:tracking-widest" />
            <button type="submit"
                class="shrink-0 rounded-full bg-white text-black font-bold px-5 py-3 text-sm hover:bg-neutral-200 transition-colors">
                Upload & Import
            </button>
        </form>

        <p class="mt-4 text-xs text-white/40">
            Kolom wajib: <strong>Nama</strong> dan <strong>Kategori</strong> (harus sama persis salah satu dari:
            Crew, Media, Partner, Venue, Colleague, DJ/Musician Colleague, Artist/Production Team, Inner Circle).
            Kolom lain (Grup, Maks Pax, Wajib Isi Nama, Catatan) opsional. Baris yang gagal validasi otomatis
            dilewati, gak bikin baris lain ikut gagal.
        </p>
    </div>
@endsection
