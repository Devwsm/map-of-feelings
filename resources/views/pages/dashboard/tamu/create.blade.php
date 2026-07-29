{{--
    Path: resources/views/pages/dashboard/tamu/create.blade.php
    Route: GET /dashboard/tamu/create -> pressconGuestController@create (role:admin)

    Preview di kanan update live pas ngetik (JS murni, gak ada request ke server).
    Slug yang ditampilin di preview itu APROKSIMASI doang buat gambaran — slug final
    yang beneran disimpan tetap dihitung server-side lewat pressconGuest::generateSlug()
    pas form di-submit (jadi kalau ada nama kembar, penanganan -2/-3 tetap kejadian
    di server, bukan di preview ini).
--}}
@extends('template.dashboard.layout')
@section('title', 'Tambah Tamu')

@section('body')
    <a href="{{ route('dashboard.tamu') }}"
        class="text-xs font-bold uppercase tracking-widest text-white/40 hover:text-white/70 transition-colors">&larr;
        Kembali ke Tamu</a>
    <h1 class="text-3xl font-bold mt-3 mb-8">Tambah Tamu</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- FORM --}}
        <form action="{{ route('dashboard.tamu.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-bold mb-2">Nama</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                    placeholder="Contoh: Ancha"
                    class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
                @error('name')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category" class="block text-sm font-bold mb-2">Kategori</label>
                <select id="category" name="category" required
                    class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40">
                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>
                            {{ $category }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="group" class="block text-sm font-bold mb-2">Group (opsional)</label>
                <input id="group" name="group" type="text" value="{{ old('group') }}"
                    placeholder="Contoh: WSM Crew"
                    class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
            </div>

            <div>
                <label for="max_pax" class="block text-sm font-bold mb-2">Max Pax</label>
                <input id="max_pax" name="max_pax" type="number" min="1" value="{{ old('max_pax', 1) }}" required
                    class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40" />
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="requires_name" value="1" {{ old('requires_name') ? 'checked' : '' }}
                    class="rounded border-white/30 bg-neutral-900" />
                Nama masih slot tim (butuh dikonfirmasi tamu)
            </label>

            <div>
                <label for="details" class="block text-sm font-bold mb-2">Catatan internal (gak ditampilin ke tamu)</label>
                <textarea id="details" name="details" rows="3"
                    class="w-full rounded-2xl border border-white/15 bg-neutral-900 px-4 py-3 focus:outline-none focus:border-white/40">{{ old('details') }}</textarea>
            </div>

            <button type="submit"
                class="rounded-full bg-white text-black font-bold px-6 py-3 hover:bg-neutral-200 transition-colors">Simpan
                Tamu</button>
        </form>

        {{-- LIVE PREVIEW --}}
        <div class="lg:sticky lg:top-8 self-start">
            <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-3">Preview</p>

            <div class="rounded-3xl bg-neutral-900 border border-white/10 p-8 text-center">
                <p class="text-xs font-bold uppercase tracking-widest text-white/50">INVITATION FOR</p>
                <h2 id="previewName" class="text-4xl font-bold mt-2 mb-2">Nama Tamu</h2>
                <p id="previewCategory" class="text-lg text-white/60">Pilih kategori</p>
                <p id="previewGroup" class="text-sm text-white/40 mt-1" style="display:none"></p>

                <div class="mt-6 pt-5 border-t border-white/15">
                    <p class="text-xs font-bold uppercase tracking-widest text-white/40 mb-2">Check-in Code (perkiraan)</p>
                    <p id="previewSlug" class="font-mono text-lg font-bold">WSM-GEN-NAMA</p>
                </div>
            </div>

            <p class="mt-3 text-xs text-white/40">Slug final ditentukan pas disimpan — bisa beda kalau ada nama kembar
                (otomatis ditambah -2, -3, dst).</p>
        </div>
    </div>

    <script>
        (function() {
            const nameInput = document.getElementById('name');
            const categorySelect = document.getElementById('category');
            const groupInput = document.getElementById('group');

            const previewName = document.getElementById('previewName');
            const previewCategory = document.getElementById('previewCategory');
            const previewGroup = document.getElementById('previewGroup');
            const previewSlug = document.getElementById('previewSlug');

            // Sama persis kayak pressconGuest::categoryCode() di model — cuma buat preview,
            // slug ASLI tetap dihitung server-side.
            const categoryCodes = {
                'Crew': 'CRE',
                'Media': 'MED',
                'Partner': 'PAR',
                'Venue': 'VEN',
                'Colleague': 'COL',
                'DJ/Musician Colleague': 'DJM',
                'Artist/Production Team': 'ART',
                'Inner Circle': 'INN',
            };

            function slugifyName(text) {
                return text
                    .trim()
                    .toUpperCase()
                    .replace(/[^A-Z0-9]+/g, '-')
                    .replace(/(^-|-$)/g, '') || 'NAMA';
            }

            function updatePreview() {
                const name = nameInput.value.trim();
                const category = categorySelect.value;
                const group = groupInput.value.trim();

                previewName.textContent = name || 'Nama Tamu';
                previewCategory.textContent = category || 'Pilih kategori';

                if (group) {
                    previewGroup.textContent = `Group: ${group}`;
                    previewGroup.style.display = '';
                } else {
                    previewGroup.style.display = 'none';
                }

                const code = categoryCodes[category] || 'GEN';
                previewSlug.textContent = `WSM-${code}-${slugifyName(name)}`;
            }

            [nameInput, categorySelect, groupInput].forEach((el) => el.addEventListener('input', updatePreview));
            updatePreview();
        })();
    </script>
@endsection
