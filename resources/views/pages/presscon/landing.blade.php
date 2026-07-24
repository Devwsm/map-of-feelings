@extends('template.presscon.layout')

@section('title', 'Map of Feelings — Press Conference & Listening Session')
@section('container-class', 'flex flex-col')

@section('content')
    <main class="flex-1 grid place-items-center px-5 pb-10 sm:px-14">
        <div class="w-full">
            @include('pages.presscon.partials.hero-content')
        </div>
    </main>
@endsection
