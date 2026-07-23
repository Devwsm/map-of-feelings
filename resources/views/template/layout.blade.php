<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Map Of Feelings</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link rel="icon" href="{{ asset('aset/logo/.png') }}" type="image/png"> --}}
</head>

<body class="flex flex-col w-full  justify-center items-center">
    @yield('content')
</body>
