@extends('layouts.app')

@section('content')
    <h1 class="mb-6 text-3xl font-bold capitalize text-slate-900">Real estate projects in {{ str_replace('-', ' ', $segment) }}</h1>

    <livewire:project-listing :segment="$segment" />
@endsection
