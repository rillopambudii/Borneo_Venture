@extends('layouts.app')

@section('title', 'Kelola Empat Aspek')

@section('content')
<section class="max-w-4xl mx-auto px-6 pt-12 pb-20">
    @include('partials.admin.nav', ['title' => 'Empat Aspek Eksplorasi'])
    <livewire:aspect-manager />
</section>
@endsection
