{{--
    Path: resources/views/pages/dashboard/tamu/edit.blade.php
    Route: GET /dashboard/tamu/{guest}/edit -> pressconGuestController@edit (role:admin)
--}}
@extends('template.dashboard.layout')
@section('title', 'Edit Tamu')

@section('body')
    <a href="{{ route('dashboard.tamu') }}"
        class="text-xs font-bold uppercase tracking-widest text-white/40 hover:text-white/70 transition-colors">&larr;
        Kembali ke Tamu</a>
    <h1 class="text-3xl font-bold mt-3 mb-8">Edit {{ $guest->name }}</h1>

    <div class="max-w-2xl rounded-3xl bg-neutral-900 border border-white/10 p-6 mb-6 flex items-center gap-6">
        @if ($guest->qrUrl())
            <img src="{{ $guest->qrUrl() }}" alt="QR check-in" class="w-24 h-24 shrink-0 bg-white rounded-xl p-2" />
        @else
            <div
                class="w-24 h-24 shrink-0 rounded-xl border border-dashed border-white/20 grid place-items-center text-xs text-white/40 text-center">
                Belum ada QR</div>
        @endif

        <div class="flex-1">
            <p class="text-sm text-white/60 mb-3">
                {{ $guest->qr_generated ? 'QR sudah pernah digenerate.' : 'QR belum digenerate.' }}</p>
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
        </div>
    </div>

    <form action="{{ route('dashboard.tamu.update', $guest->slug) }}" method="POST" class="max-w-xl space-y-5">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block text-sm font-bold mb-2">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name', $guest->name) }}" required
                class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
            @error('name')
                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category" class="block text-sm font-bold mb-2">Kategori</label>
            <select id="category" name="category" required
                class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40">
                @foreach ($categories as $category)
                    <option value="{{ $category }}"
                        {{ old('category', $guest->category) === $category ? 'selected' : '' }}>{{ $category }}
                    </option>
                @endforeach
            </select>
            @error('category')
                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="group" class="block text-sm font-bold mb-2">Group</label>
            <input id="group" name="group" type="text" value="{{ old('group', $guest->group) }}"
                class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
        </div>

        <div>
            <label for="max_pax" class="block text-sm font-bold mb-2">Max Pax</label>
            <input id="max_pax" name="max_pax" type="number" min="1"
                value="{{ old('max_pax', $guest->max_pax) }}" required
                class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="requires_name" value="1"
                {{ old('requires_name', $guest->requires_name) ? 'checked' : '' }}
                class="rounded border-white/30 bg-neutral-900" />
            Nama masih slot tim (butuh dikonfirmasi tamu)
        </label>

        <div>
            <label for="details" class="block text-sm font-bold mb-2">Catatan internal (gak ditampilin ke tamu)</label>
            <textarea id="details" name="details" rows="3"
                class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40">{{ old('details', $guest->details) }}</textarea>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                class="rounded-full bg-white text-black font-bold px-6 py-3 hover:bg-neutral-200 transition-colors">Simpan
                Perubahan</button>
            <a href="{{ route('presscon-inv.guest', $guest->slug) }}" target="_blank"
                class="text-sm font-bold text-white/50 hover:text-white/80 transition-colors">Lihat halaman tamu &rarr;</a>
        </div>
    </form>
@endsection
