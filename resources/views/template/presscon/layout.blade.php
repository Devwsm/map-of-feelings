{{--
    Layout khusus press-con (BEDA dari template/layout.blade.php situs utama).
    Dipakai oleh landing.blade.php & guest.blade.php lewat @extends('pages.presscon.layout').

    Section yang bisa di-override child:
    - title            -> <title> tag, default "Map of Feelings — Press Conference & Listening Session"
    - container-class  -> class tambahan di wrapper <div> (misal landing butuh flex biar hero center,
        guest butuh pb-14 buat jarak sebelum footer)
    - content          -> isi utama halaman (wajib diisi di child)

    Header (logo + tombol Admin) otomatis include di sini, jadi gak perlu ditulis ulang di
    landing/guest.
--}}
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Map of Feelings — Press Conference & Listening Session')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('assets/logo/logo-wsm.svg') }}" type="image/svg+xml">
</head>

<body class="min-h-screen presscon-bg font-sans text-neutral-900">
    <div class="relative min-h-screen max-w-5xl mx-auto @yield('container-class')">
        @include('pages.presscon.partials.header')
        @yield('content')
    </div>
</body>

</html>
