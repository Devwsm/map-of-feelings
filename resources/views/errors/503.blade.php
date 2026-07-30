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
@endsection
