@extends('layouts.app')

@section('title', 'Kelola Tentang Kami')

@section('content')
<section class="max-w-4xl mx-auto px-6 pt-12 pb-20">
    @include('partials.admin.nav', ['title' => 'Tentang Kami'])
    <livewire:about-manager />
</section>
@endsection
