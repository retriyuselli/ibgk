<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $showDevelopmentGate = config('site.under_development')
        && ! auth()->check()
        && request()->routeIs('home');
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'IBGK Sumsel'))</title>
    <meta name="description" content="@yield('meta_description', $profile?->short_description ?? 'Ikatan Bujang Gadis Kampus Sumatera Selatan')">

    {!! Vite::fonts() !!}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body @class(['relative min-h-screen overflow-x-hidden bg-cream font-sans text-ink antialiased', 'overflow-hidden' => $showDevelopmentGate])>
    @if ($showDevelopmentGate)
        @include('partials.site.development-gate')
    @endif

    @include('partials.site.header')

    <main class="relative z-10">
        @yield('content')
    </main>

    <div class="relative z-10">
        @include('partials.site.footer')
    </div>
</body>
</html>
