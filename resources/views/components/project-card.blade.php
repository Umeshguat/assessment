@props(['project', 'eager' => false])

<article {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md']) }}>
    <a href="{{ url('/propertydetail/' . $project->slug) }}" class="block">
        <img
            src="{{ $project->image ? asset('uploads/400/' . $project->image) : asset('img/placeholder.webp') }}"
            alt="{{ $project->title }}"
            width="400" height="300"
            class="aspect-[4/3] w-full bg-slate-100 object-cover"
            decoding="async"
            @if ($eager) fetchpriority="high" @else loading="lazy" @endif
        >
        <div class="p-4">
            <h3 class="text-lg font-semibold text-slate-900">{{ $project->title }}</h3>
            <p class="mt-1 text-sm text-slate-500">
                {{ $project->developer?->name }}@if ($project->bhk) · {{ $project->bhk }} BHK @endif · {{ ucfirst($project->city) }}
            </p>
            @if ($project->price)
                <p class="mt-2 font-semibold text-indigo-600">₹{{ number_format($project->price / 10000000, 2) }} Cr</p>
            @endif
            <p class="mt-2 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($project->description), 140) }}</p>
        </div>
    </a>
</article>
