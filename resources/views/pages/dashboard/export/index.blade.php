{{--
    Path: resources/views/pages/dashboard/export/index.blade.php
    Route: GET /dashboard/export -> importExportController@index (role:admin)
--}}
@extends('template.dashboard.layout')
@section('title', 'Export / Import')

@section('body')
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Kelola Data</p>
        <h1 class="text-3xl font-bold">Export / Import</h1>
    </div>

    <div class="space-y-4">
        {{-- FULL DB BACKUP --}}
        <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="font-bold mb-1">Backup Full Database</p>
                    <p class="text-sm text-white/50">Semua tabel jadi satu file .sql. Pakai ini sebelum ada
                        perubahan besar, atau buat backup rutin.</p>
                </div>
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('dashboard.export.database.preview') }}"
                        class="rounded-full border border-white/20 px-5 py-3 text-sm font-bold hover:bg-white/10 transition-colors">Preview</a>
                    <a href="{{ route('dashboard.export.database') }}"
                        onclick="return confirm('Download backup full database sekarang?');"
                        class="rounded-full bg-white text-black font-bold px-5 py-3 text-sm hover:bg-neutral-200 transition-colors">
                        Download .sql
                    </a>
                </div>
            </div>
        </div>

        {{-- DATA LAGU --}}
        <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="font-bold mb-1">Data Lagu Didownload</p>
                    <p class="text-sm text-white/50">Histori pengunjung yang submit mood & dapat rekomendasi lagu.
                        Total {{ $totalSubmissions }} data.</p>
                </div>
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('dashboard.export.mood-submissions.preview') }}" target="_blank"
                        class="rounded-full border border-white/20 px-5 py-3 text-sm font-bold hover:bg-white/10 transition-colors">Preview</a>
                    <a href="{{ route('dashboard.export.mood-submissions.excel') }}"
                        class="rounded-full border border-white/20 px-5 py-3 text-sm font-bold hover:bg-white/10 transition-colors">Excel</a>
                    <a href="{{ route('dashboard.export.mood-submissions.pdf') }}"
                        class="rounded-full border border-white/20 px-5 py-3 text-sm font-bold hover:bg-white/10 transition-colors">PDF</a>
                </div>
            </div>
        </div>

        {{-- DATA TAMU CHECK-IN --}}
        <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="font-bold mb-1">Data Tamu Check-in</p>
                    <p class="text-sm text-white/50">Tamu yang sudah check-in beserta staff yang meng-check-in-kan.
                        Total {{ $totalCheckedIn }} tamu.</p>
                </div>
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('dashboard.export.guest-checkin.preview') }}" target="_blank"
                        class="rounded-full border border-white/20 px-5 py-3 text-sm font-bold hover:bg-white/10 transition-colors">Preview</a>
                    <a href="{{ route('dashboard.export.guest-checkin.excel') }}"
                        class="rounded-full border border-white/20 px-5 py-3 text-sm font-bold hover:bg-white/10 transition-colors">Excel</a>
                    <a href="{{ route('dashboard.export.guest-checkin.pdf') }}"
                        class="rounded-full border border-white/20 px-5 py-3 text-sm font-bold hover:bg-white/10 transition-colors">PDF</a>
                </div>
            </div>
        </div>
    </div>
@endsection
