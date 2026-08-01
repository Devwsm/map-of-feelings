@extends('template.layout')

@section('container-class', 'bg-black')
@section('content')
    <div class="min-h-screen flex flex-col uppercase items-center justify-center text-center px-4">
        <h1 class="text-8xl font-bold text-white">403</h1>
        <p class="text-2xl font-semibold text-white mt-4">Akses ditolak</p>
        <p class="text-white mt-2">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ route('home') }}"
            class="mt-6 px-4 py-2 bg-white text-black rounded-lg font-semibold hover:bg-gray-100 transition">
            Kembali ke Beranda
        </a>
    </div>
@endsection
