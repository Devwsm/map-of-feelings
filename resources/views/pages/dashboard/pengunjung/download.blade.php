{{--
    Path: resources/views/pages/dashboard/pengunjung/download.blade.php
    Route: GET /dashboard/pengunjung/download -> visitorController@download (role:admin)
--}}
@extends('template.dashboard.layout')
@section('title', 'Pengunjung — Download')

@section('body')
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Analitik</p>
        <h1 class="text-3xl font-bold">Pengunjung</h1>
    </div>

    {{-- TOGGLE KUNJUNGAN/DOWNLOAD --}}
    <div class="flex gap-2 mb-6">
        <a href="{{ route('dashboard.pengunjung') }}"
            class="rounded-full border border-white/20 px-4 py-2 text-xs font-bold uppercase tracking-widest text-white/60 hover:bg-white/10 transition-colors">Kunjungan</a>
        <span class="rounded-full bg-white text-black px-4 py-2 text-xs font-bold uppercase tracking-widest">Download</span>
    </div>

    {{-- STATISTIK --}}
    <div class="mb-6">
        <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6 inline-block">
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Total yang Download</p>
            <p class="text-3xl font-bold">{{ number_format($totalDownloads) }}</p>
        </div>
    </div>

    {{-- TABEL 100 TERAKHIR --}}
    <div class="rounded-3xl bg-neutral-900 border border-white/10 overflow-hidden">
        <div class="px-6 py-4 border-b border-white/10">
            <p class="font-bold">100 Download Terakhir</p>
            <p class="text-sm text-white/50">Pengunjung yang submit mood & download hasil koordinatnya. Diurut dari
                yang paling baru.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-white/40 text-xs uppercase tracking-widest border-b border-white/10">
                        <th class="px-6 py-3 font-bold">Nama</th>
                        <th class="px-6 py-3 font-bold">Instagram</th>
                        <th class="px-6 py-3 font-bold">Mood</th>
                        <th class="px-6 py-3 font-bold">IP</th>
                        <th class="px-6 py-3 font-bold">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submissions as $submission)
                        <tr class="border-b border-white/5 last:border-0">
                            <td class="px-6 py-3 whitespace-nowrap">{{ $submission->visitor_name ?: '-' }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-white/70">
                                {{ $submission->visitor_instagram ? '@' . ltrim($submission->visitor_instagram, '@') : '-' }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-white/70">{{ $submission->mood->feeling ?? '-' }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-white/50">{{ $submission->ip_address ?? '-' }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-white/50">
                                {{ $submission->created_at?->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-white/40">Belum ada data download.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
