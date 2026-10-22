<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('partials.seo', ['seo' => $seo ?? ($page ?? null)])
    @stack('head')
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @livewireStyles
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">
    <main class="mx-auto max-w-6xl px-4 py-8">
        @yield('content')
    </main>
    @livewireScripts
</body>
</html>
