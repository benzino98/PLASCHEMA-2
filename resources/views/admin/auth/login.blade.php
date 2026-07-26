<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sign In — Admin — {{ config('app.name', 'PLASCHEMA') }}</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center p-4 bg-gradient-to-br from-primary-50 via-white to-secondary-50 font-sans text-slate-800 antialiased">
    <div class="w-full max-w-md">
        <!-- Logo and Heading -->
        <div class="text-center mb-8">
            <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-primary text-xl font-black text-white shadow-md shadow-primary-100 mb-4 animate-bounce">
                P
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">Sign in to Admin</h2>
            <p class="mt-2 text-sm text-slate-600">
                Plateau State Contributory Healthcare Management Agency
            </p>
        </div>

        <!-- Form Card -->
        <div class="card bg-white p-8 border border-slate-100 shadow-xl rounded-[var(--radius-card)]">
            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <i data-lucide="mail" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            value="{{ old('email') }}"
                            class="block w-full rounded-[var(--radius-button)] border border-slate-200 py-3 pl-10 pr-4 text-slate-900 placeholder:text-slate-400 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 text-sm transition"
                            placeholder="you@plaschema.gov.ng"
                        >
                    </div>
                    @error('email')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                    </div>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <i data-lucide="lock" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="block w-full rounded-[var(--radius-button)] border border-slate-200 py-3 pl-10 pr-4 text-slate-900 placeholder:text-slate-400 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 text-sm transition"
                            placeholder="••••••••"
                        >
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember_me"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary accent-primary"
                        >
                        <label for="remember_me" class="ml-2 block text-sm font-medium text-slate-600">
                            Remember this device
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn-primary w-full py-3 justify-center text-sm font-bold shadow-md shadow-primary-50 hover:shadow-lg transition duration-200">
                        Sign In
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Back to Website -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:text-primary-700 transition">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Back to public website
            </a>
        </div>
    </div>

    <!-- Script to ensure Lucide icons reload -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.refreshIcons) {
                window.refreshIcons();
            }
        });
    </script>
</body>
</html>
