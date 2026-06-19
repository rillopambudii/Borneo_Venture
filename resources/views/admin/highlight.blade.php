@extends('layouts.app')

@section('title', 'Kelola Eksplorasi Borneo')

@section('content')
<section class="max-w-4xl mx-auto px-6 pt-12 pb-20">
    @include('partials.admin.nav', ['title' => 'Eksplorasi Borneo'])
    <livewire:highlight-manager />
</section>
@endsection
