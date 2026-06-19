@extends('layouts.app')

@section('title', 'Kelola Galeri')

@section('content')

<section class="max-w-4xl mx-auto px-6 pt-12 pb-20">
    @include('partials.admin.nav', ['title' => 'Kelola Galeri'])
    <livewire:gallery-manager />
</section>

@endsection
