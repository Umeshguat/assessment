@php
    $title       = data_get($seo, 'meta_title') ?: trim($__env->yieldContent('title')) ?: config('app.name', 'MoneyTree Realty');
    $description = data_get($seo, 'meta_description') ?: trim($__env->yieldContent('meta_description')) ?: config('seo.default_description', 'Browse RERA-registered projects, flats and plots with MoneyTree Realty.');
    $canonical   = data_get($seo, 'canonical') ?: url()->current();
@endphp
<title>{{ $title }}</title>
<meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($description), 160) }}">
<link rel="canonical" href="{{ $canonical }}">
@if (data_get($seo, 'noindex'))
    <meta name="robots" content="noindex, follow">
@endif
