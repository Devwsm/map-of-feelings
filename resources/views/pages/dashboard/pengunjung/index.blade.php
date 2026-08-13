{{--
    Path: resources/views/pages/dashboard/pengunjung/index.blade.php
    Route: GET /dashboard/pengunjung -> visitorController@index (role:admin)
--}}
@extends('template.dashboard.layout')
@section('title', 'Pengunjung')

@section('body')
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Analitik</p>
        <h1 class="text-3xl font-bold">Pengunjung</h1>
    </div>

    {{-- TOGGLE KUNJUNGAN/DOWNLOAD --}}
    <div class="flex gap-2 mb-6">
        <span class="rounded-full bg-white text-black px-4 py-2 text-xs font-bold uppercase tracking-widest">Kunjungan</span>
        <a href="{{ route('dashboard.pengunjung.download') }}"
            class="rounded-full border border-white/20 px-4 py-2 text-xs font-bold uppercase tracking-widest text-white/60 hover:bg-white/10 transition-colors">Download</a>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6">
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Total Pengunjung</p>
            <p class="text-3xl font-bold">{{ number_format($totalVisitors) }}</p>
        </div>
        <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6">
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                Sedang Mengakses
            </p>
            <p class="text-3xl font-bold">{{ number_format($onlineNow) }}</p>
        </div>
    </div>

    {{-- TABEL 100 TERAKHIR --}}
    <div class="rounded-3xl bg-neutral-900 border border-white/10 overflow-hidden">
        <div class="px-6 py-4 border-b border-white/10">
            <p class="font-bold">100 Kunjungan Terakhir</p>
            <p class="text-sm text-white/50">Diurut dari yang paling baru aktif. Data lengkap gak ditampilkan semua
                biar halaman tetap ringan.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-white/40 text-xs uppercase tracking-widest border-b border-white/10">
                        <th class="px-6 py-3 font-bold">Halaman</th>
                        <th class="px-6 py-3 font-bold">IP</th>
                        <th class="px-6 py-3 font-bold">Browser</th>
                        <th class="px-6 py-3 font-bold">Device</th>
                        <th class="px-6 py-3 font-bold">Platform</th>
                        <th class="px-6 py-3 font-bold">Terakhir Aktif</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($visitors as $visitor)
                        <tr class="border-b border-white/5 last:border-0">
                            <td class="px-6 py-3 whitespace-nowrap">{{ $visitor->url ?? '-' }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-white/70">{{ $visitor->ip_address ?? '-' }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-white/70">{{ $visitor->browser ?? '-' }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-white/70 capitalize">
                                {{ $visitor->device_type ?? '-' }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-white/70">{{ $visitor->platform ?? '-' }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-white/50">
                                {{ $visitor->updated_at?->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-white/40">Belum ada data kunjungan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
