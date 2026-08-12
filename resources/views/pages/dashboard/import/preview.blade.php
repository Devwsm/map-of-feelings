{{--
    Path: resources/views/pages/dashboard/import/preview.blade.php
    Route: POST /dashboard/import/tamu -> importExportController@importGuestsPreview (role:admin)

    Ditampilkan setelah file diupload & divalidasi, TAPI SEBELUM ada apapun
    yang disimpan ke database. Admin cek dulu baris valid & baris error di
    sini, baru pilih Konfirmasi (commit beneran) atau Batal (file sementara
    dihapus, gak ada jejak apapun).
--}}
@extends('template.dashboard.layout')
@section('title', 'Preview Import Tamu')

@section('body')
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Kelola Data</p>
        <h1 class="text-3xl font-bold">Preview Import</h1>
        <p class="text-sm text-white/50 mt-2">File: <strong class="text-white">{{ $originalName }}</strong> —
            {{ $totalRows }} baris data ditemukan.</p>
    </div>

    <div class="flex flex-wrap gap-3 mb-6">
        <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-5 py-3">
            <p class="text-xs uppercase tracking-widest text-emerald-300/70">Siap diimport</p>
            <p class="text-2xl font-bold text-emerald-300">{{ count($validRows) }}</p>
        </div>
        <div class="rounded-2xl border border-amber-500/30 bg-amber-500/10 px-5 py-3">
            <p class="text-xs uppercase tracking-widest text-amber-300/70">Bakal dilewati</p>
            <p class="text-2xl font-bold text-amber-300">{{ count($rowErrors) }}</p>
        </div>
    </div>

    @if (count($rowErrors) > 0)
        <div class="mb-6 rounded-2xl border border-amber-500/30 bg-amber-500/10 px-4 py-3 text-sm text-amber-300">
            <p class="font-bold mb-2">Baris yang bakal dilewati:</p>
            <ul class="space-y-1 max-h-48 overflow-y-auto">
                @foreach ($rowErrors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TABEL PREVIEW BARIS VALID --}}
    <div class="rounded-3xl bg-neutral-900 border border-white/10 overflow-hidden mb-6">
        <div class="p-6 pb-0">
            <p class="font-bold mb-1">Baris yang akan diimport</p>
            <p class="text-sm text-white/50 mb-4">
                Slug tiap tamu (kode check-in) baru digenerate pas konfirmasi, jadi belum ditampilkan di sini.
            </p>
        </div>

        @if (count($validRows) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-t border-white/10 text-left text-white/40 text-xs uppercase tracking-widest">
                            <th class="px-6 py-3 font-bold">Nama</th>
                            <th class="px-6 py-3 font-bold">Kategori</th>
                            <th class="px-6 py-3 font-bold">Grup</th>
                            <th class="px-6 py-3 font-bold">Maks Pax</th>
                            <th class="px-6 py-3 font-bold">Wajib Isi Nama</th>
                            <th class="px-6 py-3 font-bold">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($validRows as $row)
                            <tr class="border-t border-white/5">
                                <td class="px-6 py-3 font-medium">{{ $row['name'] }}</td>
                                <td class="px-6 py-3 text-white/60">{{ $row['category'] }}</td>
                                <td class="px-6 py-3 text-white/60">{{ $row['group'] ?? '—' }}</td>
                                <td class="px-6 py-3 text-white/60">{{ $row['max_pax'] }}</td>
                                <td class="px-6 py-3 text-white/60">{{ $row['requires_name'] ? 'Ya' : 'Tidak' }}</td>
                                <td class="px-6 py-3 text-white/60">{{ $row['details'] ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="px-6 pb-6 text-sm text-white/40">Gak ada baris valid yang bisa diimport dari file ini.</p>
        @endif
    </div>

    {{-- AKSI --}}
    <div class="flex flex-col sm:flex-row gap-3">
        <form action="{{ route('dashboard.import.tamu.confirm') }}" method="POST" class="flex-1">
            @csrf
            <button type="submit" @if (count($validRows) === 0) disabled @endif
                class="w-full rounded-full bg-white text-black font-bold px-5 py-3 text-sm hover:bg-neutral-200 transition-colors disabled:opacity-30 disabled:cursor-not-allowed">
                Konfirmasi Import ({{ count($validRows) }} tamu)
            </button>
        </form>
        <form action="{{ route('dashboard.import.tamu.cancel') }}" method="POST" class="flex-1 sm:flex-none">
            @csrf
            <button type="submit"
                class="w-full sm:w-auto rounded-full border border-white/20 px-5 py-3 text-sm font-bold hover:bg-white/10 transition-colors">
                Batal
            </button>
        </form>
    </div>
@endsection
