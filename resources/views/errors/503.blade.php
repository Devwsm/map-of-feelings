@extends('template.layout')
@section('content')
    <section class="maintenance-bg min-h-screen flex items-center justify-center p-6 text-center font-sans text-neutral-900">
        <div class="max-w-4xl">
            <img src="{{ asset('assets/logo/logo-map-of-feelings.svg') }}" class="w-250" alt="Map of Feelings"
                class="w-full h-auto object-contain mx-auto" />
            <p class="sm:mb-2 text-sm sm:text-xl font-semibold">an album by Whisnu Santika</p>
            <p class="maintenance-date text-xl sm:text-4xl font-bold m-0">27 AGUSTUS 2026</p>
        </div>
    </section>

    <style>
        .maintenance-bg {
            width: 100vw;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            background:
                radial-gradient(circle at 8% 15%, #d7f2a4b3, transparent 42%),
                radial-gradient(circle at 72% 12%, #cdeaf8b3, transparent 46%),
                radial-gradient(circle at 90% 88%, #d9f2a0b3, transparent 46%),
                #ffffff;
        }

        .maintenance-date {
            letter-spacing: 0.3em;
        }

        @media (max-width: 640px) {
            .maintenance-date {
                letter-spacing: 0.18em;
            }
        }
    </style>
@endsection
