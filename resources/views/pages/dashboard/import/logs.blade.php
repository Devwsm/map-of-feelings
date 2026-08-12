{{--
    Path: resources/views/pages/dashboard/import/logs.blade.php
    Route: GET /dashboard/import/logs -> importExportController@importLogs (role:admin)

    Riwayat setiap kali import tamu BENERAN dieksekusi (bukan preview yang
    dibatalkan). Berguna buat audit kalau banyak admin/staff yang pegang akses.
--}}
@extends('template.dashboard.layout')
@section('title', 'Riwayat Import')

@section('body')
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Kelola Data</p>
        <h1 class="text-3xl font-bold">Riwayat Import</h1>
    </div>

    <div class="flex gap-2 mb-6">
        <a href="{{ route('dashboard.import') }}"
            class="rounded-full border border-white/20 px-4 py-2 text-xs font-bold uppercase tracking-widest text-white/60 hover:bg-white/10 transition-colors">&larr;
            Kembali ke Import</a>
    </div>

    <div class="rounded-3xl bg-neutral-900 border border-white/10 overflow-hidden">
        @forelse ($logs as $log)
            <div class="p-6 border-t border-white/5 first:border-t-0 flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex-1">
                    <p class="font-bold">{{ $log->original_filename }}</p>
                    <p class="text-sm text-white/50 mt-1">
                        Oleh {{ $log->user?->name ?? 'User terhapus' }} &middot;
                        {{ $log->created_at->format('d M Y, H:i') }} WIB
                    </p>
                </div>

                <div class="flex gap-2 text-xs font-bold uppercase tracking-widest">
                    <span class="rounded-full bg-white/10 px-3 py-1.5 text-white/60">
                        {{ $log->total_rows }} baris
                    </span>
                    <span class="rounded-full bg-emerald-500/10 px-3 py-1.5 text-emerald-300">
                        {{ $log->imported_count }} berhasil
                    </span>
                    @if ($log->skipped_count > 0)
                        <span class="rounded-full bg-amber-500/10 px-3 py-1.5 text-amber-300">
                            {{ $log->skipped_count }} dilewati
                        </span>
                    @endif
                </div>

                @if ($log->skipped_count > 0)
                    <details class="w-full sm:w-auto">
                        <summary
                            class="cursor-pointer text-xs font-bold uppercase tracking-widest text-white/40 hover:text-white/70 transition-colors">
                            Lihat detail
                        </summary>
                        <ul class="mt-2 space-y-1 text-xs text-white/50 max-h-40 overflow-y-auto">
                            @foreach ($log->errors ?? [] as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </details>
                @endif
            </div>
        @empty
            <div class="p-10 text-center">
                <p class="font-bold mb-1">Belum ada riwayat import</p>
                <p class="text-sm text-white/50">Riwayat bakal muncul di sini setiap kali ada import yang
                    dikonfirmasi.</p>
            </div>
        @endforelse
    </div>

    @if ($logs->hasPages())
        <div class="mt-6 bg-white rounded-2xl p-2 inline-block">
            {{ $logs->links() }}
        </div>
    @endif
@endsection
