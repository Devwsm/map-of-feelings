{{--
    Path: resources/views/pages/dashboard/checkin.blade.php
    Route: GET /dashboard/checkin -> checkinController@index (role:admin,staff)

    2 cara input, sama-sama muara ke POST /dashboard/checkin/{slug}:
    - Search dropdown (AJAX ke checkinController@search)
    - Scan kamera (library html5-qrcode dari CDN, decode QR jadi teks slug)
--}}
@extends('template.dashboard.layout')
@section('title', 'Check-in')

@section('body')
    <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Hari-H</p>
    <h1 class="text-3xl font-bold mb-2">Check-in</h1>
    <p id="counterText" class="text-white/50 mb-8">{{ $checkedInCount }} dari {{ $totalGuests }} tamu udah check-in</p>

    {{-- FEEDBACK --}}
    <div id="feedback" class="hidden mb-6 rounded-2xl px-4 py-3 text-sm font-semibold"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- SEARCH DROPDOWN --}}
        <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6">
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-3">Cari Tamu</p>

            <div class="relative">
                <input id="searchInput" type="text" placeholder="Ketik nama atau kode tamu..." autocomplete="off"
                    class="w-full rounded-2xl border border-white/15 bg-neutral-800 px-4 py-3 focus:outline-none focus:border-white/40" />
                <div id="searchResults"
                    class="hidden absolute z-10 mt-2 w-full rounded-2xl border border-white/10 bg-neutral-800 max-h-64 overflow-y-auto">
                </div>
            </div>
        </div>

        {{-- SCAN QR --}}
        <div class="rounded-3xl bg-neutral-900 border border-white/10 p-6">
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-3">Scan QR</p>

            <button id="scanToggle" type="button"
                class="w-full rounded-2xl bg-white text-black font-bold py-3 hover:bg-neutral-200 transition-colors">Buka
                Kamera</button>
            <div id="scanBox" class="hidden mt-4 rounded-2xl overflow-hidden"></div>
            <p class="mt-3 text-xs text-white/40">Butuh izin kamera & koneksi HTTPS.</p>
        </div>
    </div>

    {{-- RIWAYAT TERAKHIR --}}
    <p class="text-xs font-bold uppercase tracking-widest text-white/40 mt-10 mb-3">Check-in Terakhir</p>
    <div id="recentList" class="space-y-2">
        @forelse ($recent as $guest)
            <div
                class="flex items-center justify-between rounded-2xl bg-neutral-900 border border-white/10 px-4 py-3 text-sm">
                <span class="font-bold">{{ $guest->submitted_name ?: $guest->name }}</span>
                <span class="text-white/40">{{ optional($guest->arrival_time)->format('H:i') }} &middot;
                    {{ $guest->checkedInBy->name ?? '-' }}</span>
            </div>
        @empty
            <p class="text-sm text-white/40">Belum ada yang check-in.</p>
        @endforelse
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    <script>
        (function() {
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');
            const feedback = document.getElementById('feedback');
            const counterText = document.getElementById('counterText');
            const recentList = document.getElementById('recentList');
            const scanToggle = document.getElementById('scanToggle');
            const scanBox = document.getElementById('scanBox');

            let checkedInCount = {{ $checkedInCount }};
            const totalGuests = {{ $totalGuests }};
            let searchTimer = null;
            let scanner = null;

            function showFeedback(status, message) {
                const colors = {
                    success: 'bg-emerald-500/10 border border-emerald-500/30 text-emerald-300',
                    already: 'bg-amber-500/10 border border-amber-500/30 text-amber-300',
                    declined: 'bg-rose-500/10 border border-rose-500/30 text-rose-300',
                    error: 'bg-rose-500/10 border border-rose-500/30 text-rose-300',
                };
                feedback.className = 'mb-6 rounded-2xl px-4 py-3 text-sm font-semibold ' + colors[status];
                feedback.textContent = message;
                feedback.classList.remove('hidden');
            }

            function prependRecent(name, time) {
                const row = document.createElement('div');
                row.className =
                    'flex items-center justify-between rounded-2xl bg-neutral-900 border border-white/10 px-4 py-3 text-sm';
                row.innerHTML = `<span class="font-bold">${name}</span><span class="text-white/40">${time}</span>`;
                recentList.prepend(row);
            }

            async function submitCheckin(slug, force = false) {
                try {
                    const url = `/dashboard/checkin/${encodeURIComponent(slug)}` + (force ? '?force=1' : '');
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    });

                    if (response.status === 404) {
                        showFeedback('error', 'Kode/nama tidak ditemukan.');
                        return;
                    }

                    const data = await response.json();

                    // Tamu sudah declare tidak hadir -> minta staff konfirmasi ulang
                    // sebelum benar-benar diproses check-in.
                    if (data.status === 'declined') {
                        showFeedback('declined', data.message);
                        const confirmResult = await Swal.fire({
                            icon: 'warning',
                            title: 'Tamu ini sudah RSVP "Tidak Hadir"',
                            text: `${data.name} sudah konfirmasi tidak hadir. Tetap check-in tamu ini?`,
                            showCancelButton: true,
                            confirmButtonText: 'Ya, tetap check-in',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#e11d48',
                            cancelButtonColor: '#3f3f46',
                        });
                        if (confirmResult.isConfirmed) {
                            await submitCheckin(slug, true);
                        }
                        return;
                    }

                    showFeedback(data.status, data.message);

                    if (data.status === 'success') {
                        checkedInCount += 1;
                        counterText.textContent = `${checkedInCount} dari ${totalGuests} tamu udah check-in`;
                        prependRecent(data.name, data.time);
                    }
                } catch (error) {
                    showFeedback('error', 'Gagal memproses check-in, coba lagi.');
                }
            }

            // ===== Search dropdown =====
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimer);
                const q = searchInput.value.trim();

                if (!q) {
                    searchResults.classList.add('hidden');
                    return;
                }

                searchTimer = setTimeout(async () => {
                    const response = await fetch(
                        `/dashboard/checkin/search?q=${encodeURIComponent(q)}`);
                    const results = await response.json();

                    searchResults.innerHTML = '';
                    if (results.length === 0) {
                        searchResults.innerHTML =
                            '<p class="px-4 py-3 text-sm text-white/40">Gak ketemu.</p>';
                    } else {
                        results.forEach((guest) => {
                            const item = document.createElement('button');
                            item.type = 'button';
                            item.className =
                                'w-full text-left px-4 py-3 text-sm hover:bg-white/10 transition-colors flex items-center justify-between';
                            item.innerHTML = `
                                <span>${guest.label} <span class="text-white/40">&middot; ${guest.category}</span></span>
                                ${guest.checked_in ? '<span class="text-xs text-emerald-400">Sudah</span>' : ''}
                            `;
                            item.addEventListener('click', () => {
                                searchResults.classList.add('hidden');
                                searchInput.value = '';
                                submitCheckin(guest.slug);
                            });
                            searchResults.appendChild(item);
                        });
                    }
                    searchResults.classList.remove('hidden');
                }, 300);
            });

            document.addEventListener('click', (event) => {
                if (!searchResults.contains(event.target) && event.target !== searchInput) {
                    searchResults.classList.add('hidden');
                }
            });

            // ===== Scan kamera =====
            scanToggle.addEventListener('click', () => {
                if (scanner) {
                    scanner.stop().then(() => {
                        scanner = null;
                        scanBox.classList.add('hidden');
                        scanToggle.textContent = 'Buka Kamera';
                    });
                    return;
                }

                scanBox.classList.remove('hidden');
                scanBox.innerHTML = '<div id="scanRegion"></div>';
                scanToggle.textContent = 'Tutup Kamera';

                scanner = new Html5Qrcode('scanRegion');
                scanner.start({
                        facingMode: 'environment'
                    }, {
                        fps: 10,
                        qrbox: 220
                    },
                    (decodedText) => {
                        submitCheckin(decodedText.trim());
                    }
                ).catch(() => {
                    showFeedback('error',
                        'Gagal buka kamera. Cek izin browser atau pakai search manual.');
                    scanBox.classList.add('hidden');
                    scanToggle.textContent = 'Buka Kamera';
                    scanner = null;
                });
            });
        })();
    </script>
@endsection
