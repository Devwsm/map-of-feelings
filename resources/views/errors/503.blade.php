@extends('template.layout')

@section('content')
    <section class="relative min-h-screen w-full grid place-items-center overflow-hidden bg-white text-center px-6">
        <div class="mof-intro-color-field" aria-hidden="true"></div>
        <div class="relative z-2 w-[min(850px,82vw)]">
            <img src="{{ asset('assets/logo/logo-map-of-feelings.svg') }}" alt="Map of Feelings" class="block w-full h-auto" />
            <p class="sm:mb-4 text-sm sm:text-xl font-semibold">an album by Whisnu Santika</p>
            <p class="font-mono tracking-[.22em] text-2xl sm:text-5xl font-semibold">27 AGUSTUS 2026</p>
        </div>
    </section>
    <script>
        (function() {
            const palette = [
                ['#DCEBFF', '#0954E3'],
                ['#3EAD9C', '#FCA547'],
                ['#F8DDD0', '#BCC59A'],
                ['#7D351F', '#C48773'],
                ['#7695FB', '#C69FF8'],
                ['#FFF0C9', '#F7B94D'],
                ['#9EC9AE', '#FC8D80'],
                ['#A6E67A', '#62B158'],
                ['#DE842D', '#A89C42'],
                ['#4CB69C', '#2F776B']
            ];

            function hexToRgb(hex) {
                const clean = hex.replace('#', '');
                return `${parseInt(clean.slice(0, 2), 16)}, ${parseInt(clean.slice(2, 4), 16)}, ${parseInt(clean.slice(4, 6), 16)}`;
            }

            let index = 0;

            function applyColor() {
                const [primary, secondary] = palette[index];
                document.documentElement.style.setProperty('--mof-orbit-primary-rgb', hexToRgb(primary));
                document.documentElement.style.setProperty('--mof-orbit-secondary-rgb', hexToRgb(secondary));
                index = (index + 1) % palette.length;
            }

            applyColor();
            setInterval(applyColor, 2200);
        })();
    </script>
@endsection
