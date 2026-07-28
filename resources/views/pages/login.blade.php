@extends('template.layout')
@section('container-class', 'bg-black')

@section('content')
    <div class="min-h-screen w-full flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-sm">
            <p class="text-center text-white/60 text-sm font-bold tracking-widest mb-8">MAP OF FEELINGS DASHBOARD</p>

            <div class="rounded-3xl bg-neutral-900 text-white p-8">
                <h1 class="text-2xl font-bold text-center mb-6">Masuk</h1>
                @if ($errors->any())
                    <div class="mb-4 rounded-2xl border border-rose-500/40 bg-rose-500/10 px-4 py-3 text-sm text-rose-300">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-bold mb-2">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full rounded-2xl border border-white/20 bg-neutral-800 px-4 py-3 text-white placeholder:text-white/40 focus:outline-none focus:border-white/50"
                        />
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-bold mb-2">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="w-full rounded-2xl border border-white/20 bg-neutral-800 px-4 py-3 text-white placeholder:text-white/40 focus:outline-none focus:border-white/50"
                        />
                    </div>
                    <label class="flex items-center gap-2 text-sm text-white/70">
                        <input type="checkbox" name="remember" class="rounded border-white/30 bg-neutral-800" />
                        Ingat saya
                    </label>
                    <button
                        type="submit"
                        class="w-full rounded-full bg-white text-black font-bold py-3 hover:bg-neutral-200 transition-colors"
                    >Masuk</button>
                </form>
            </div>
        </div>
    </div>
@endsection