{{--
    Path: resources/views/pages/dashboard/tamu/index.blade.php
    Route: GET /dashboard/tamu -> pressconGuestController@index (role:admin)
--}}
@extends('template.dashboard.layout')
@section('title', 'Tamu')

@section('body')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Kelola Data</p>
            <h1 class="text-3xl font-bold">Tamu</h1>
        </div>
        <a href="{{ route('dashboard.tamu.create') }}"
            class="rounded-full bg-white text-black font-bold px-5 py-3 text-sm hover:bg-neutral-200 transition-colors">+
            Tambah Tamu</a>
    </div>

    {{-- SEARCH + FILTER --}}
    <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama tamu..."
            class="flex-1 rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 text-sm placeholder:text-white/30 focus:outline-none focus:border-white/40" />

        <select name="category"
            class="rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 text-sm focus:outline-none focus:border-white/40">
            <option value="">Semua kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                    {{ $category }}</option>
            @endforeach
        </select>

        <button type="submit"
            class="rounded-2xl border border-white/15 px-5 py-3 text-sm font-bold hover:bg-white/10 transition-colors">Cari</button>
        @if (request('search') || request('category'))
            <a href="{{ route('dashboard.tamu') }}"
                class="rounded-2xl border border-white/15 px-5 py-3 text-sm font-bold text-white/60 hover:bg-white/10 transition-colors text-center">Reset</a>
        @endif
    </form>

    {{-- LIST --}}
    <div class="space-y-3 mb-6">
        @forelse ($guests as $guest)
            <div
                class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-6 rounded-3xl bg-neutral-900 border border-white/10 p-5">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <span
                        class="w-2.5 h-2.5 rounded-full shrink-0 {{ \App\Models\pressconGuest::categoryColor($guest->category) }}"></span>
                    <div class="min-w-0">
                        <p class="font-bold truncate">{{ $guest->submitted_name ?: $guest->name }}</p>
                        <p class="text-xs text-white/40 truncate">
                            {{ $guest->category }}
                            @if ($guest->group)
                                &middot; {{ $guest->group }}
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 text-xs shrink-0">
                    <span class="font-mono text-white/50">{{ $guest->slug }}</span>

                    @if ($guest->checked_in)
                        <span
                            class="rounded-full bg-emerald-500/15 text-emerald-300 px-3 py-1 font-bold whitespace-nowrap">Checked
                            In</span>
                    @elseif ($guest->rsvp_status === 'tidak_hadir')
                        <span class="rounded-full bg-rose-500/15 text-rose-300 px-3 py-1 font-bold whitespace-nowrap">Tidak
                            Hadir</span>
                    @else
                        <span class="rounded-full bg-white/10 text-white/50 px-3 py-1 font-bold whitespace-nowrap">Belum
                            Respons</span>
                    @endif
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <form action="{{ route('dashboard.tamu.generate-qr', $guest->slug) }}" method="POST">
                        @csrf
                        @if ($guest->qr_generated)
                            <button type="submit"
                                class="rounded-full border border-amber-500/30 text-amber-300 px-4 py-2 text-xs font-bold hover:bg-amber-500/10 transition-colors">Regenerate
                                QR</button>
                        @else
                            <button type="submit"
                                class="rounded-full border border-emerald-500/30 text-emerald-300 px-4 py-2 text-xs font-bold hover:bg-emerald-500/10 transition-colors">Generate
                                QR</button>
                        @endif
                    </form>

                    <a href="{{ route('dashboard.tamu.edit', $guest->slug) }}"
                        class="rounded-full border border-white/20 px-4 py-2 text-xs font-bold hover:bg-white/10 transition-colors">Edit</a>
                    <form action="{{ route('dashboard.tamu.destroy', $guest->slug) }}" method="POST"
                        class="js-confirm-delete" data-guest-name="{{ $guest->name }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="rounded-full border border-rose-500/30 text-rose-300 px-4 py-2 text-xs font-bold hover:bg-rose-500/10 transition-colors">Hapus</button>
                    </form>
                </div>

            </div>
        @empty
            <div class="rounded-3xl border border-dashed border-white/15 p-10 text-center">
                <p class="font-bold mb-1">Gak ada tamu yang cocok</p>
                <p class="text-sm text-white/50">Coba kata kunci lain atau reset filter.</p>
            </div>
        @endforelse
    </div>

    @if ($guests->hasPages())
        <div class="bg-white rounded-2xl p-2 inline-block">
            {{ $guests->links() }}
        </div>
    @endif

    <script>
        document.addEventListener('submit', function(event) {
            const form = event.target.closest('.js-confirm-delete');
            if (!form) return;

            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Hapus tamu ini?',
                text: `${form.dataset.guestName} akan dihapus permanen. Aksi ini gak bisa dibatalin.`,
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#3f3f46',
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    </script>
@endsection
