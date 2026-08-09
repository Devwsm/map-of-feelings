{{--
    Path: resources/views/template/dashboard/layout.blade.php
    Extends resources/views/template/layout.blade.php (layout situs utama).

    Dipakai semua halaman dashboard lewat @extends('template.dashboard.layout').

    Section/variable yang bisa di-override child:
    - title    -> @section('title', 'Nama Halaman') — muncul di identity bar
    - active   -> variable $active dioper dari CONTROLLER (bukan @section), value:
        'home' | 'tamu' | 'tambah' | 'checkin' | 'export-import'
        dipakai buat nge-highlight tab yang lagi aktif
    - body     -> @section('body') ... @endsection — isi utama halaman

    Nav otomatis nyaring menu sesuai role: staff cuma liat Home & Check-in.
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

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-bold">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] font-bold uppercase tracking-widest text-white/40">{{ auth()->user()->role }}
                        </p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="rounded-full border border-white/20 px-4 py-2 text-xs font-bold uppercase tracking-widest hover:bg-white/10 transition-colors">Keluar</button>
                    </form>
                </div>
            </div>
        </header>

        {{-- TAB NAV --}}
        @php $active = $active ?? 'home'; @endphp
        <nav class="border-b border-white/10">
            <div class="max-w-6xl mx-auto px-6 flex gap-8 text-xs font-bold uppercase tracking-widest overflow-x-auto">
                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                    <a href="{{ route('dashboard') }}"
                        class="py-4 border-b-2 {{ $active === 'home' ? 'border-white text-white' : 'border-transparent text-white/40 hover:text-white/70' }} transition-colors whitespace-nowrap">Home</a>
                @endif

                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('dashboard.tamu') }}"
                        class="py-4 border-b-2 {{ $active === 'tamu' ? 'border-white text-white' : 'border-transparent text-white/40 hover:text-white/70' }} transition-colors whitespace-nowrap">Tamu</a>
                    <a href="{{ route('dashboard.tamu.create') }}"
                        class="py-4 border-b-2 {{ $active === 'tambah' ? 'border-white text-white' : 'border-transparent text-white/40 hover:text-white/70' }} transition-colors whitespace-nowrap">Tambah</a>
                @endif

                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                    <a href="{{ route('dashboard.checkin') }}"
                        class="py-4 border-b-2 {{ $active === 'checkin' ? 'border-white text-white' : 'border-transparent text-white/40 hover:text-white/70' }} transition-colors whitespace-nowrap">Check-in</a>
                @endif

                @if (auth()->user()->role === 'panel' || auth()->user()->role === 'admin')
                    <a href="{{ route('dashboard.panel') }}"
                        class="py-4 border-b-2 {{ $active === 'panel' ? 'border-white text-white' : 'border-transparent text-white/40 hover:text-white/70' }} transition-colors whitespace-nowrap">Panel</a>
                @endif

                @if (auth()->user()->role === 'admin')
                    <a href="#"
                        class="py-4 border-b-2 border-transparent text-white/40 hover:text-white/70 transition-colors whitespace-nowrap">Export/Import</a>
                @endif
            </div>
        </nav>

        <main class="max-w-6xl mx-auto px-6 py-10">
            @yield('body')
        </main>
    </div>
@endsection
