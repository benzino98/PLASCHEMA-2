<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — Admin — {{ config('app.name', 'PLASCHEMA') }}</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-slate-100 antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        {{-- Mobile sidebar overlay --}}
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"
            @click="sidebarOpen = false"
            x-cloak
        ></div>

        {{-- Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-slate-200 bg-white transition-transform duration-300 lg:static lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            <div class="flex h-16 items-center gap-3 border-b border-slate-200 px-6">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary text-xs font-bold text-white">P</div>
                <div>
                    <p class="text-sm font-bold text-slate-900">PLASCHEMA</p>
                    <p class="text-xs text-slate-500">Admin Panel</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1 p-4" aria-label="Admin navigation">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'admin-nav-link-active' : '' }}">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.pages.index') }}" class="admin-nav-link {{ request()->routeIs('admin.pages.*') ? 'admin-nav-link-active' : '' }}">
                    <i data-lucide="file-text" class="h-4 w-4"></i>
                    Pages
                </a>
                <a href="{{ route('admin.health-plans.index') }}" class="admin-nav-link {{ request()->routeIs('admin.health-plans.*') ? 'admin-nav-link-active' : '' }}">
                    <i data-lucide="heart-pulse" class="h-4 w-4"></i>
                    Health Plans
                </a>
                <a href="{{ route('admin.providers.index') }}" class="admin-nav-link {{ request()->routeIs('admin.providers.*') ? 'admin-nav-link-active' : '' }}">
                    <i data-lucide="building-2" class="h-4 w-4"></i>
                    Providers
                </a>
                <a href="{{ route('admin.news.index') }}" class="admin-nav-link {{ request()->routeIs('admin.news.*') ? 'admin-nav-link-active' : '' }}">
                    <i data-lucide="newspaper" class="h-4 w-4"></i>
                    News
                </a>
                <a href="{{ route('admin.downloads.index') }}" class="admin-nav-link {{ request()->routeIs('admin.downloads.*') ? 'admin-nav-link-active' : '' }}">
                    <i data-lucide="download" class="h-4 w-4"></i>
                    Downloads
                </a>
                <a href="{{ route('admin.faqs.index') }}" class="admin-nav-link {{ request()->routeIs('admin.faqs.*') ? 'admin-nav-link-active' : '' }}">
                    <i data-lucide="help-circle" class="h-4 w-4"></i>
                    FAQs
                </a>
                <a href="{{ route('admin.messages.index') }}" class="admin-nav-link {{ request()->routeIs('admin.messages.*') ? 'admin-nav-link-active' : '' }}">
                    <i data-lucide="mail" class="h-4 w-4"></i>
                    Messages
                </a>
                <a href="{{ route('admin.settings.home') }}" class="admin-nav-link {{ request()->routeIs('admin.settings.home') ? 'admin-nav-link-active' : '' }}">
                    <i data-lucide="settings" class="h-4 w-4"></i>
                    Settings
                </a>
                <a href="{{ route('admin.settings.services') }}" class="admin-nav-link {{ request()->routeIs('admin.settings.services') ? 'admin-nav-link-active' : '' }}">
                    <i data-lucide="globe" class="h-4 w-4"></i>
                    Services
                </a>
                @if(auth()->user()?->isAdmin())
                    <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'admin-nav-link-active' : '' }}">
                        <i data-lucide="users" class="h-4 w-4"></i>
                        Users
                    </a>
                @endif
            </nav>

            <div class="border-t border-slate-200 p-4 space-y-1">
                <a href="{{ route('home') }}" class="admin-nav-link">
                    <i data-lucide="external-link" class="h-4 w-4"></i>
                    View Public Site
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="admin-nav-link w-full text-left">
                        <i data-lucide="log-out" class="h-4 w-4"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content area --}}
        <div class="flex flex-1 flex-col">
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 lg:px-8">
                <button
                    type="button"
                    class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden"
                    @click="sidebarOpen = !sidebarOpen"
                    aria-label="Toggle sidebar"
                >
                    <i data-lucide="menu" class="h-5 w-5"></i>
                </button>

                <h1 class="text-lg font-semibold text-slate-900">@yield('page_heading', 'Dashboard')</h1>

                <div class="flex items-center gap-3">
                    <span class="hidden text-sm text-slate-500 sm:inline">{{ auth()->user()->name }}</span>
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-50 text-xs font-semibold text-primary">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
