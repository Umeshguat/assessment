@extends('layouts.app')

@section('content')
    <h1>{{ $page->heading }}</h1>
    @if ($page->intro)<p>{{ $page->intro }}</p>@endif

    @foreach ($projects as $project)
        <x-project-card :project="$project" :eager="$loop->first" />
    @endforeach

    {{ $projects->links() }}

    @foreach ($faqs as $f)
                <details><summary>{{ $f->question }}</summary>{!! clean($f->answer) !!}</details>
    @endforeach

        @php
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'itemListElement' => $projects->values()->map(fn ($p, $i) => [
                '@type' => 'ListItem',
                'position' => $projects->firstItem() + $i,
                'name' => $p->title,
                'url' => url('/propertydetail/' . $p->slug),
            ])->all(),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
@endsection
