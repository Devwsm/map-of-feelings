@extends('template.presscon.layout')

@section('title', 'Undangan — Map of Feelings Press Conference')
@section('container-class', 'pb-14')

@section('content')
    <main class="px-5 pt-14 sm:px-14 sm:pt-24 text-center">
        @include('pages.presscon.partials.hero-content')
        {{-- GUEST CARD --}}
        <div class="rounded-3xl bg-neutral-900 text-white p-6 text-center sm:p-10">
            <p class="text-xs font-extrabold tracking-widest text-white/70">INVITATION FOR</p>
            <h2 class="text-4xl sm:text-5xl font-extrabold mt-2 mb-2">Arga</h2> {{-- GANTI: $guest->name --}}
            <p class="text-xl text-white/70">Dev</p> {{-- GANTI: $guest->category --}}
            <p class="text-sm text-white/60 mt-1">Group: WSM Crew</p> {{-- GANTI: 'Group: '.$guest->group --}}

            <div class="mt-6 pt-5 border-t border-white/20">
                <label for="guestInputName" class="block text-sm font-extrabold mb-2">Nama lengkap</label>
                <input id="guestInputName" name="submitted_name" type="text" value="Arga"
                    placeholder="Isi nama lengkap kamu"
                    class="w-full rounded-2xl border border-white/40 bg-neutral-800 px-4 py-4 text-center font-extrabold text-white placeholder:text-white/40 placeholder:font-normal focus:outline-none focus:border-white/70" />
                <p class="mt-3 text-sm leading-relaxed text-white/60">
                    Pastikan nama sudah benar untuk RSVP dan check-in.
                </p>
                {{-- Kalau $guest->requiresName true, ganti hint di atas jadi:
                        "Undangan ini masih memakai nama slot tim. Isi nama lengkap kamu." --}}
            </div>
        </div>

        {{-- DATE / START --}}
        <div class="mt-6 grid grid-cols-2 gap-4">
            <div class="min-h-32 rounded-3xl bg-white flex flex-col items-center justify-center px-4 py-5">
                <p class="text-xs font-extrabold tracking-widest text-black/50 mb-2">DATE</p>
                <p class="font-extrabold text-lg sm:text-xl">26 AUG 2026</p>
            </div>
            <div class="min-h-32 rounded-3xl bg-white flex flex-col items-center justify-center px-4 py-5">
                <p class="text-xs font-extrabold tracking-widest text-black/50 mb-2">START</p>
                <p class="font-extrabold text-lg sm:text-xl">15.00 WIB</p>
            </div>
        </div>

        {{-- VENUE --}}
        <a href="https://www.google.com/maps/search/?api=1&query=Samrock+Gandaria" target="_blank" rel="noopener"
            class="mt-4 block rounded-3xl bg-white px-6 py-6 text-black no-underline">
            <p class="text-xs font-extrabold tracking-widest text-black/50 mb-2">VENUE</p>
            <p class="font-extrabold text-xl sm:text-2xl">Samrock Gandaria</p>
            <span class="block mt-2 text-sm text-black/60">Buka Google Maps ↗</span>
        </a>

        {{-- QR CHECK-IN (placeholder) --}}
        <div class="mt-4 rounded-3xl bg-white p-6 flex flex-col sm:flex-row items-center gap-6">
            <div
                class="w-36 h-36 sm:w-56 sm:h-56 shrink-0 grid place-items-center bg-white p-3 border-2 border-neutral-900">
                <img src="{{ asset('assets/qr/WSM-ART-1.png') }}" alt="WSM" class="block w-full h-full" />
            </div>
            <div class="text-center sm:text-left">
                <p class="text-xs font-extrabold tracking-widest text-black/50 mb-2">CHECK-IN CODE</p>
                <h3 class="text-xl sm:text-3xl font-extrabold my-2">WSM-CRE-001</h3> {{-- GANTI: $guest->id --}}
                <p class="text-black/60">Tunjukkan QR atau kode ini saat datang.</p>
            </div>
        </div>

        {{-- RSVP PANEL --}}
        <form action="#" method="POST" class="mt-8">
            @csrf

            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                <div class="mb-5">
                    <p class="text-xs font-extrabold uppercase tracking-[0.25em] text-neutral-500">
                        RSVP
                    </p>
                    <h3 class="mt-2 text-lg font-bold text-neutral-900">
                        Konfirmasi Kehadiran
                    </h3>
                    <p class="mt-1 text-sm text-neutral-500">
                        Silakan pilih jika tidak hadir dan tuliskan alasannya.
                    </p>
                </div>

                <input type="hidden" name="rsvp" value="Tidak Hadir">

                <label for="note" class="mb-2 block text-sm font-semibold text-neutral-800">
                    Alasan tidak hadir
                </label>
                <textarea id="note" name="note" rows="4" placeholder="Contoh: Ada acara keluarga atau sedang di luar kota"
                    class="w-full rounded-2xl border border-black/10 bg-neutral-50 px-4 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-neutral-300 focus:bg-white focus:outline-none focus:ring-4 focus:ring-neutral-900/5"></textarea>

                <button type="submit"
                    class="mt-5 inline-flex w-full items-center justify-center rounded-full bg-neutral-900 px-5 py-4 text-sm font-extrabold text-white transition-colors hover:bg-black">
                    Simpan RSVP
                </button>
            </div>
        </form>

    </main>

    <footer class="text-center px-5 py-8 text-sm sm:px-14 sm:py-14">copyright &copy; WahSudahMonday {{ date('Y') }}
    </footer>
@endsection
