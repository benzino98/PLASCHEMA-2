<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $pageTitle = $__env->yieldContent('title');
        $metaTitle = $__env->yieldContent('og_title', $pageTitle ?: config('app.name', 'PLASCHEMA'));
        $metaDescription = $__env->yieldContent('og_description', $__env->yieldContent('meta_description', 'Affordable healthcare for every Plateau citizen. Plateau State Contributory Healthcare Management Agency.'));
        $canonicalUrl = $__env->yieldContent('canonical', url()->current());
    @endphp

    <title>{{ $pageTitle ? $pageTitle.' — ' : '' }}{{ config('app.name', 'PLASCHEMA') }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="color-scheme" content="light dark">

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ $canonicalUrl }}">

    {{-- Open Graph --}}
    <meta property="og:site_name" content="{{ config('app.name', 'PLASCHEMA') }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="{{ $metaTitle }} — {{ config('app.name', 'PLASCHEMA') }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    @hasSection('meta_image')<meta property="og:image" content="@yield('meta_image')">@endif
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="{{ $metaTitle }} — {{ config('app.name', 'PLASCHEMA') }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    @hasSection('meta_image')<meta name="twitter:image" content="@yield('meta_image')">@endif

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="flex min-h-screen flex-col" x-data="{ mobileNavOpen: false }" @keydown.escape.window="mobileNavOpen = false">
    <a href="#main-content" class="skip-link">Skip to main content</a>

    @include('partials.header')
    @include('partials.mobile-nav')

    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.assistant')

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.notyf?.success(@json(session('success')));
            });
        </script>
    @endif

    @include('partials.analytics')
    @stack('scripts')
</body>
</html>
