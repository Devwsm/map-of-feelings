{{--
    Path: resources/views/pages/presscon/guest.blade.php
    Route: GET /presscon-inv/{guest} -> pressconGuestController@show (route model binding via slug)
    Extends resources/views/template/presscon/layout.blade.php.

    Urutan section (revisi): guest card -> QR + check-in code -> date/start -> venue -> RSVP (bawah).
    Konsep RSVP: "Hadir" HANYA ditentukan staff lewat check-in (scan/kode) — bukan self-report tamu.
    Form RSVP di sini cuma buat declining ("Tidak Hadir"), dengan opsi batalin kalau berubah pikiran.

    QR masih placeholder ikon — nanti diganti generate asli begitu queue QR generation jalan.
--}}
@extends('template.presscon.layout')

@section('title', 'Undangan — Map of Feelings Press Conference')
@section('container-class', 'pb-14')

@section('content')
    <main class="px-5 pt-14 sm:px-14 sm:pt-24 text-center">
        @include('pages.presscon.partials.hero-content')

        {{-- GUEST CARD + KONFIRMASI NAMA --}}
        <div class="mt-8 rounded-3xl bg-neutral-900 text-white p-6 text-center sm:p-10">
            <p class="text-xs font-bold tracking-widest text-white/70">INVITATION FOR</p>
            <h2 class="text-4xl sm:text-5xl font-bold mt-2 mb-2">{{ $guest->submitted_name ?: $guest->name }}</h2>
            <p class="text-xl text-white/70">{{ $guest->category }}</p>
            @if ($guest->group)
                <p class="text-sm text-white/60 mt-1">Group: {{ $guest->group }}</p>
            @endif

            <form action="{{ route('presscon-inv.rsvp', $guest->slug) }}" method="POST"
                class="mt-6 pt-5 border-t border-white/20">
                @csrf
                <input type="hidden" name="action" value="confirm_name" />

                <label for="guestInputName" class="block text-sm font-bold mb-2">Nama lengkap</label>
                <input id="guestInputName" name="submitted_name" type="text"
                    value="{{ old('submitted_name', $guest->submitted_name ?: $guest->name) }}"
                    placeholder="Isi nama lengkap kamu"
                    class="w-full rounded-2xl border border-white/40 bg-neutral-800 px-4 py-4 text-center font-bold text-white placeholder:text-white/40 placeholder:font-normal focus:outline-none focus:border-white/70" />
                <p class="mt-3 text-sm leading-relaxed text-white/60">
                    @if ($guest->requires_name)
                        Undangan ini masih memakai nama slot tim. Isi nama lengkap kamu.
                    @else
                        Pastikan nama sudah benar untuk RSVP dan check-in.
                    @endif
                </p>

                @if (session('rsvp_saved') === 'confirm_name')
                    <p class="mt-3 text-sm font-semibold text-emerald-400">Nama berhasil diperbarui.</p>
                @endif

                <button type="submit"
                    class="mt-4 rounded-full border border-white/40 px-5 py-2.5 text-sm font-bold hover:bg-white/10 transition-colors">Simpan
                    Nama</button>
            </form>
        </div>

        {{-- QR CHECK-IN (placeholder) --}}
        <div class="mt-4 rounded-3xl bg-white p-6 flex flex-col sm:flex-row items-center gap-6">
            <div
                class="w-36 h-36 sm:w-56 sm:h-56 shrink-0 grid place-items-center bg-white p-3 border-2 border-neutral-900">
                @if ($guest->qrUrl())
                    <img src="{{ $guest->qrUrl() }}" alt="QR check-in" class="block mx-auto w-full h-auto object-contain" />
                @else
                    <img src="{{ asset('assets/qr/qr.png') }}" alt="QR check-in (placeholder)"
                        class="block mx-auto w-full h-auto object-contain" />
                @endif
            </div>
            <div class="text-center sm:text-left">
                <p class="text-xs font-bold tracking-widest text-black/50 mb-2">CHECK-IN CODE</p>
                <h3 class="text-xl sm:text-3xl font-bold my-2">{{ $guest->slug }}</h3>
                <p class="text-black/60">Tunjukkan QR atau kode ini saat datang.</p>
            </div>
        </div>

        {{-- DATE / START --}}
        <div class="mt-4 grid grid-cols-2 gap-4">
            <div class="min-h-32 rounded-3xl bg-white flex flex-col items-center justify-center px-4 py-5">
                <p class="text-xs font-bold tracking-widest text-black/50 mb-2">DATE</p>
                <p class="font-bold text-lg sm:text-xl">26 AUG 2026</p>
            </div>
            <div class="min-h-32 rounded-3xl bg-white flex flex-col items-center justify-center px-4 py-5">
                <p class="text-xs font-bold tracking-widest text-black/50 mb-2">START</p>
                <p class="font-bold text-lg sm:text-xl">15.00 WIB</p>
            </div>
        </div>

        {{-- VENUE --}}
        <a href="https://www.google.com/maps/search/?api=1&query=Samrock+Gandaria" target="_blank" rel="noopener"
            class="mt-4 block rounded-3xl bg-white px-6 py-6 text-black no-underline">
            <p class="text-xs font-bold tracking-widest text-black/50 mb-2">VENUE</p>
            <p class="font-bold text-xl sm:text-2xl">Shamrock Gandaria</p>
            <span class="block mt-2 text-sm text-black/60">Buka Google Maps ↗</span>
        </a>

        {{-- RSVP PANEL (cuma buat declining, di paling bawah) --}}
        <div class="mt-4 rounded-3xl bg-white p-6">
            @if ($guest->rsvp_status === 'tidak_hadir')
                {{-- STATE: sudah konfirmasi tidak hadir -> tampilin ringkasan + tombol batalkan --}}
                <div class="flex items-center justify-center gap-2 mb-3">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    <p class="text-xs font-bold tracking-widest text-rose-600">TIDAK HADIR</p>
                </div>

                <p class="font-bold text-lg">Kamu sudah konfirmasi tidak hadir.</p>

                @if ($guest->note)
                    <p
                        class="mt-3 max-w-sm mx-auto rounded-2xl border border-black/10 bg-neutral-50 px-4 py-3 text-sm italic text-black/70">
                        &ldquo;{{ $guest->note }}&rdquo;</p>
                @endif

                @if (session('rsvp_saved') === 'decline')
                    <p class="mt-3 text-sm font-semibold text-emerald-600">Konfirmasi tersimpan.</p>
                @elseif (session('rsvp_saved') === 'cancel')
                    <p class="mt-3 text-sm font-semibold text-emerald-600">Berhasil dibatalkan.</p>
                @endif

                <form action="{{ route('presscon-inv.rsvp', $guest->slug) }}" method="POST" class="mt-5">
                    @csrf
                    <input type="hidden" name="action" value="cancel" />
                    <button type="submit"
                        class="w-full rounded-full bg-neutral-900 text-white font-bold py-4 hover:bg-black transition-colors">Batalkan,
                        Saya Bisa Hadir</button>
                </form>
            @else
                {{-- STATE: belum declare apa-apa -> form buat declining --}}
                <p class="text-xs font-bold tracking-widest">GAK BISA HADIR?</p>
                <p class="mt-2 text-sm text-black/60">
                    Kehadiran resmi ditentukan lewat check-in di lokasi (scan QR/kode di atas).
                    Form ini cuma buat kasih tau lebih awal kalau kamu gak bisa datang.
                </p>

                @if (session('rsvp_saved') === 'cancel')
                    <p class="mt-3 text-sm font-semibold text-emerald-600">Berhasil dibatalkan, statusmu balik ke belum
                        konfirmasi.</p>
                @endif

                <form action="{{ route('presscon-inv.rsvp', $guest->slug) }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="action" value="decline" />

                    <label for="note" class="block text-left font-bold mb-2">Catatan (opsional)</label>
                    <textarea id="note" name="note" placeholder="Contoh: ada acara lain di waktu bersamaan"
                        class="w-full min-h-28 rounded-2xl border border-black/15 p-4 text-sm placeholder:text-black/40 focus:outline-none focus:border-black/30">{{ old('note') }}</textarea>

                    <button type="submit"
                        class="w-full mt-4 rounded-full bg-neutral-900 text-white font-black py-4 hover:bg-black transition-colors">Konfirmasi
                        Tidak Hadir</button>
                </form>
            @endif

            @error('submitted_name')
                <p class="mt-3 text-sm font-semibold text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </main>

    <footer class="text-center px-5 py-8 text-sm sm:px-14 sm:py-14">copyright &copy; WahSudah Monday {{ date('Y') }}
    </footer>
@endsection
