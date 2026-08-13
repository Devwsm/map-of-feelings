{{--
    Path: resources/views/template/dashboard/layout.blade.php
    Extends resources/views/template/layout.blade.php (layout situs utama).

    Dipakai semua halaman dashboard lewat @extends('template.dashboard.layout').

    Section/variable yang bisa di-override child:
    - title    -> @section('title', 'Nama Halaman') — muncul di identity bar
    - active   -> variable $active dioper dari CONTROLLER (bukan @section), value:
        'home' | 'tamu' | 'tambah' | 'checkin' | 'panel' | 'panel-submissions' | 'export-import' | 'pengunjung'
        dipakai buat nge-highlight menu yang lagi aktif di drawer
    - body     -> @section('body') ... @endsection — isi utama halaman

    Nav sekarang berupa drawer yang slide dari kanan (burger menu), gantiin tab
    bar horizontal + dropdown yang lama. Link disaring sesuai role, dikelompokkan
    per section (Tamu, Acara, Panel, Data) biar rapi walau role-nya admin (paling
    banyak menu). Vanilla JS (bukan Alpine, project ini gak load Alpine di layout
    ini), pakai style.display + style.transform langsung, bukan Tailwind hidden.
--}}
@extends('template.layout')

@section('container-class', 'bg-[#0a0a0b]')

@section('content')
    <div class="min-h-screen w-full text-white">
        {{-- IDENTITY BAR --}}
        <header class="border-b border-white/10">
            <div class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span
                        class="grid place-items-center w-9 h-9 rounded-full bg-white text-black font-['Brush_Script_MT','Segoe_Script',cursive] italic text-lg">of</span>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-widest text-white/50">Map of Feelings</p>
                        <p class="text-sm font-bold">@yield('title', 'Press Conference Dashboard')</p>
                    </div>
                </div>

                <button type="button" id="navDrawerToggle" aria-label="Buka menu navigasi" aria-expanded="false"
                    class="grid place-items-center w-10 h-10 rounded-full border border-white/20 hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none">
                        <path d="M3 5H17M3 10H17M3 15H17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
        </header>

        <main class="max-w-6xl mx-auto px-6 py-10">
            @yield('body')
        </main>
    </div>

    {{-- NAV DRAWER (slide dari kanan) --}}
    @php $active = $active ?? 'home'; @endphp

    <div id="navDrawerOverlay" style="display:none; opacity:0;"
        class="fixed inset-0 bg-black/60 z-40 transition-opacity duration-300"></div>

    <aside id="navDrawer" style="display:none; transform: translateX(100%);"
        class="fixed top-0 right-0 h-full w-72 max-w-[50vw] bg-neutral-950 border-l border-white/10 z-50 flex flex-col transition-transform duration-300 ease-out">
        <div class="flex items-center justify-between px-5 py-5 border-b border-white/10">
            <p class="text-xs font-bold uppercase tracking-widest text-white/40">Menu</p>
            <button type="button" id="navDrawerClose" aria-label="Tutup menu navigasi"
                class="w-8 h-8 grid place-items-center rounded-full hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none">
                    <path d="M3 3L13 13M13 3L3 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4 text-sm">
            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                <a href="{{ route('dashboard') }}"
                    class="block px-3 py-3 rounded-xl font-bold {{ $active === 'home' ? 'bg-white text-black' : 'text-white/70 hover:bg-white/5' }}">Home</a>
            @endif

            @if (auth()->user()->role === 'admin')
                <p class="px-3 pt-5 pb-1 text-[10px] font-bold uppercase tracking-widest text-white/30">Tamu</p>
                <a href="{{ route('dashboard.tamu') }}"
                    class="block px-3 py-3 rounded-xl font-bold {{ $active === 'tamu' ? 'bg-white text-black' : 'text-white/70 hover:bg-white/5' }}">Semua
                    Tamu</a>
                <a href="{{ route('dashboard.tamu.create') }}"
                    class="block px-3 py-3 rounded-xl font-bold {{ $active === 'tambah' ? 'bg-white text-black' : 'text-white/70 hover:bg-white/5' }}">Tambah
                    Tamu</a>
            @endif

            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                <p class="px-3 pt-5 pb-1 text-[10px] font-bold uppercase tracking-widest text-white/30">Acara</p>
                <a href="{{ route('dashboard.checkin') }}"
                    class="block px-3 py-3 rounded-xl font-bold {{ $active === 'checkin' ? 'bg-white text-black' : 'text-white/70 hover:bg-white/5' }}">Check-in</a>
            @endif

            @if (auth()->user()->role === 'panel' || auth()->user()->role === 'admin')
                <p class="px-3 pt-5 pb-1 text-[10px] font-bold uppercase tracking-widest text-white/30">Panel</p>
                <a href="{{ route('dashboard.panel') }}"
                    class="block px-3 py-3 rounded-xl font-bold {{ $active === 'panel' ? 'bg-white text-black' : 'text-white/70 hover:bg-white/5' }}">Kelola
                    Mood</a>
                <a href="{{ route('dashboard.panel.submissions') }}"
                    class="block px-3 py-3 rounded-xl font-bold {{ $active === 'panel-submissions' ? 'bg-white text-black' : 'text-white/70 hover:bg-white/5' }}">Data
                    Submission</a>
            @endif

            @if (auth()->user()->role === 'admin')
                <p class="px-3 pt-5 pb-1 text-[10px] font-bold uppercase tracking-widest text-white/30">Data</p>
                <a href="{{ route('dashboard.export') }}"
                    class="block px-3 py-3 rounded-xl font-bold {{ $active === 'export-import' ? 'bg-white text-black' : 'text-white/70 hover:bg-white/5' }}">Export/Import</a>
                <a href="{{ route('dashboard.pengunjung') }}"
                    class="block px-3 py-3 rounded-xl font-bold {{ $active === 'pengunjung' ? 'bg-white text-black' : 'text-white/70 hover:bg-white/5' }}">Pengunjung</a>
            @endif
        </nav>

        <div class="px-5 py-5 border-t border-white/10">
            <p class="text-sm font-bold">{{ auth()->user()->name }}</p>
            <p class="text-[11px] font-bold uppercase tracking-widest text-white/40 mb-3">{{ auth()->user()->role }}
            </p>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full rounded-full bg-red-500 hover:bg-red-700 text-white px-4 py-2.5 text-xs font-bold uppercase tracking-widest transition-colors">Keluar</button>
            </form>
        </div>
    </aside>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('navDrawerToggle');
            const closeBtn = document.getElementById('navDrawerClose');
            const drawer = document.getElementById('navDrawer');
            const overlay = document.getElementById('navDrawerOverlay');

            if (!toggle || !drawer || !overlay) return;

            function openDrawer() {
                overlay.style.display = 'block';
                drawer.style.display = 'flex';
                // Paksa reflow dulu biar transition beneran kepakai,
                // bukan langsung lompat ke state akhir.
                drawer.offsetHeight;
                overlay.style.opacity = '1';
                drawer.style.transform = 'translateX(0)';
                toggle.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }

            function closeDrawer() {
                overlay.style.opacity = '0';
                drawer.style.transform = 'translateX(100%)';
                toggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
                setTimeout(() => {
                    overlay.style.display = 'none';
                    drawer.style.display = 'none';
                }, 300);
            }

            toggle.addEventListener('click', openDrawer);
            closeBtn?.addEventListener('click', closeDrawer);
            overlay.addEventListener('click', closeDrawer);
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') closeDrawer();
            });
        });
    </script>
@endsection
