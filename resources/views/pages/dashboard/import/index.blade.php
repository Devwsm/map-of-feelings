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
        <a href="{{ route('dashboard.import.logs') }}"
            class="rounded-full border border-white/20 px-4 py-2 text-xs font-bold uppercase tracking-widest text-white/60 hover:bg-white/10 transition-colors ml-auto">Riwayat
            Import</a>
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

        <form action="{{ route('dashboard.import.tamu.preview') }}" method="POST" enctype="multipart/form-data"
            class="flex flex-col sm:flex-row gap-3">
            @csrf
            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                class="flex-1 rounded-2xl border border-white/15 bg-neutral-950 px-4 py-3 text-sm file:mr-4 file:rounded-full file:border-0 file:bg-white file:text-black file:px-4 file:py-2 file:text-xs file:font-bold file:uppercase file:tracking-widest" />
            <button type="submit"
                class="shrink-0 rounded-full bg-white text-black font-bold px-5 py-3 text-sm hover:bg-neutral-200 transition-colors">
                Lihat Preview
            </button>
        </form>
        <p class="mt-3 text-xs text-white/40">
            File akan dicek dulu, belum langsung masuk database — kamu bisa lihat mana yang valid dan mana yang
            bakal dilewati sebelum konfirmasi.
        </p>

        {{-- PETUNJUK KOLOM --}}
        <div class="mt-6 rounded-2xl border border-white/10 bg-neutral-950 p-5">
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-3">Petunjuk Kolom</p>

            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="font-bold text-white">Nama <span class="text-red-400 font-normal">(wajib)</span></dt>
                    <dd class="text-white/50">Nama tamu, atau nama slot rombongan (mis. "Media A") kalau belum tahu nama
                        orangnya. Kosong = baris dilewati.</dd>
                </div>
                <div>
                    <dt class="font-bold text-white">Kategori <span class="text-red-400 font-normal">(wajib)</span></dt>
                    <dd class="text-white/50 mb-2">Harus persis salah satu dari daftar berikut (tidak case-sensitive, tapi
                        ejaan harus sama). Tidak cocok = baris dilewati.</dd>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach ($categories as $category)
                            <span
                                class="rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/70">{{ $category }}</span>
                        @endforeach
                    </div>
                </div>
                <div>
                    <dt class="font-bold text-white">Grup <span class="text-white/30 font-normal">(opsional)</span></dt>
                    <dd class="text-white/50">Nama rombongan/tim, bebas teks.</dd>
                </div>
                <div>
                    <dt class="font-bold text-white">Maks Pax <span class="text-white/30 font-normal">(opsional)</span></dt>
                    <dd class="text-white/50">Jumlah maksimal orang untuk satu slot tamu. Kosong atau &lt; 1 otomatis
                        dianggap 1.</dd>
                </div>
                <div>
                    <dt class="font-bold text-white">Wajib Isi Nama <span class="text-white/30 font-normal">(opsional,
                            default: Tidak)</span></dt>
                    <dd class="text-white/50">Isi "Ya" kalau Nama di atas masih nama slot tim — tamu akan diminta mengisi
                        nama aslinya sendiri saat buka undangan. Isi "Tidak" kalau Nama sudah final, tamu tinggal konfirmasi
                        ejaan.</dd>
                </div>
                <div>
                    <dt class="font-bold text-white">Catatan <span class="text-white/30 font-normal">(opsional)</span></dt>
                    <dd class="text-white/50">Catatan internal untuk admin, tidak terlihat oleh tamu.</dd>
                </div>
            </dl>

            <p class="mt-4 pt-4 border-t border-white/10 text-xs text-white/40">
                Baris yang gagal validasi otomatis dilewati saat import, tidak bikin baris lain ikut gagal.
                Template download di atas juga sudah ada sheet <strong>"Petunjuk"</strong> dan dropdown pilihan
                langsung di kolom Kategori &amp; Wajib Isi Nama, biar gak salah ketik.
            </p>
        </div>
    </div>
@endsection
