@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')

<section class="min-h-screen flex items-center justify-center px-6 py-32">
    <div class="w-full max-w-md bg-forest-800 border border-forest-600 rounded-2xl p-8 shadow-xl">
        <h1 class="font-serif text-3xl font-bold text-white mb-1">Admin Panel</h1>
        <p class="text-forest-200/60 text-sm mb-8">Masuk untuk mengelola galeri.</p>

        @if ($errors->any())
            <div class="bg-red-500/15 border border-red-500/40 text-red-200 text-sm rounded-xl px-4 py-3 mb-5">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-forest-200/80 text-sm mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="input-field" placeholder="admin@borneoventure.com" />
            </div>
            <div>
                <label class="block text-forest-200/80 text-sm mb-2">Password</label>
                <input type="password" name="password" required class="input-field" placeholder="••••••••" />
            </div>
            <label class="flex items-center gap-2 text-forest-200/70 text-sm">
                <input type="checkbox" name="remember" class="rounded border-forest-600 bg-forest-900 text-forest-500" />
                Ingat saya
            </label>
            <button type="submit" class="btn-primary w-full">Masuk</button>
        </form>
    </div>
</section>

@endsection
