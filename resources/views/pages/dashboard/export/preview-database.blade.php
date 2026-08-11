{{--
    Path: resources/views/pages/dashboard/export/preview-database.blade.php
    Route: GET /dashboard/export/database/preview -> importExportController@previewDatabase (role:admin)
--}}
@extends('template.dashboard.layout')
@section('title', 'Preview Backup Database')

@section('body')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Preview</p>
            <h1 class="text-3xl font-bold">Ringkasan Database</h1>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('dashboard.export') }}"
                class="rounded-full border border-white/20 px-5 py-3 text-sm font-bold hover:bg-white/10 transition-colors">Kembali</a>
            <a href="{{ route('dashboard.export.database') }}"
                onclick="return confirm('Download backup full database sekarang?');"
                class="rounded-full bg-white text-black font-bold px-5 py-3 text-sm hover:bg-neutral-200 transition-colors">Download
                .sql</a>
        </div>
    </div>

    <div class="rounded-3xl bg-neutral-900 border border-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/10 text-left text-white/40 text-xs uppercase tracking-widest">
                    <th class="px-5 py-3">Tabel</th>
                    <th class="px-5 py-3 text-right">Jumlah Baris</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tables as $table)
                    <tr class="border-b border-white/5 last:border-0">
                        <td class="px-5 py-3 font-bold">{{ $table['name'] }}</td>
                        <td class="px-5 py-3 text-right text-white/60">{{ $table['rows'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
