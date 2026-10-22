@props(['project', 'eager' => false])

<article class="card">
    <a href="{{ url('/propertydetail/' . $project->slug) }}">
        <img
            src="{{ $project->image ? asset('uploads/400/' . $project->image) : asset('img/placeholder.webp') }}"
            alt="{{ $project->title }}"
            width="400" height="300"
            decoding="async"
            @if ($eager) fetchpriority="high" @else loading="lazy" @endif
        >
        <h3>{{ $project->title }}</h3>
    </a>
    <p>{{ $project->developer?->name }}</p>
        <p>{{ \Illuminate\Support\Str::limit(strip_tags($project->description), 140) }}</p>
</article>
