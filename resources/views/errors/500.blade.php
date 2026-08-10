@extends('template.layout')

@section('container-class', 'bg-black relative overflow-hidden')
@section('content')
    {{-- Warna orbit dipakai bareng sama tema Map of Feelings (lihat app.css: mof-intro-color-field) --}}
    <div class="mof-intro-color-field" aria-hidden="true"></div>
    <div class="relative z-10 min-h-screen flex flex-col uppercase items-center justify-center text-center px-4">
        <h1 class="text-8xl font-bold text-white">503</h1>
        <p class="text-2xl font-semibold text-white mt-4">Sedang Pemeliharaan</p>
        <p class="text-white normal-case mt-2">
            Map of Feelings sedang menyesuaikan koordinat. Silakan coba lagi dalam beberapa saat.
        </p>
        <a href="{{ url('/') }}"
            class="mt-6 px-4 py-2 bg-white text-black rounded-lg font-semibold hover:bg-gray-100 transition">
            Kembali ke Beranda
        </a>
    </div>
@endsection
