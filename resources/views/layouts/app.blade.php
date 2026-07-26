<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title')@yield('title') — @endif{{ config('app.name', 'PLASCHEMA') }}</title>
    <meta name="description" content="@yield('meta_description', 'Affordable healthcare for every Plateau citizen. Plateau State Contributory Healthcare Management Agency.')">

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

    @stack('scripts')
</body>
</html>
