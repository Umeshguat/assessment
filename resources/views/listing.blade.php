@extends('layouts.app')

@section('content')
    <h1>Real estate projects</h1>

    @foreach ($projects as $project)
        <x-project-card :project="$project" :eager="$loop->first" />
    @endforeach

    {{ $projects->links() }}
@endsection
