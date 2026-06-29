<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Plateau State Contributory Healthcare Management Agency — affordable healthcare for every Plateau citizen.">

    <title>{{ config('app.name', 'PLASCHEMA') }}</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen bg-surface">
        <header class="border-b border-slate-200/80 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-[var(--radius-card)] bg-primary text-sm font-bold text-white">
                        P
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">PLASCHEMA</p>
                        <p class="text-xs text-slate-500">Plateau State Healthcare</p>
                    </div>
                </div>
                <span class="rounded-full bg-primary-50 px-3 py-1 text-xs font-medium text-primary">Phase 0 — Foundation</span>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
                    Affordable Healthcare For Every
                    <span class="text-primary">Plateau Citizen</span>
                </h1>
                <p class="mt-6 text-lg text-slate-600">
                    Project foundation is ready. Design tokens, tooling, and core libraries are configured for Phase 1.
                </p>
                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ config('plaschema.services.enrollment') }}" class="btn-primary" target="_blank" rel="noopener noreferrer">
                        Enroll Now
                    </a>
                    <a href="{{ config('plaschema.services.verification') }}" class="btn-secondary" target="_blank" rel="noopener noreferrer">
                        Verify Enrollment
                    </a>
                    <button type="button" class="btn-outline" onclick="window.notyf.success('PLASCHEMA foundation is working!')">
                        Test Notification
                    </button>
                </div>
            </div>

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="card-hover">
                    <div class="mb-3 h-2 w-12 rounded-full bg-primary"></div>
                    <h2 class="font-semibold text-slate-900">Primary</h2>
                    <p class="mt-1 text-sm text-slate-500">#0B8F4D — trust & health</p>
                </div>
                <div class="card-hover">
                    <div class="mb-3 h-2 w-12 rounded-full bg-secondary"></div>
                    <h2 class="font-semibold text-slate-900">Secondary</h2>
                    <p class="mt-1 text-sm text-slate-500">#1E88E5 — clarity</p>
                </div>
                <div class="card-hover">
                    <div class="mb-3 h-2 w-12 rounded-full bg-accent"></div>
                    <h2 class="font-semibold text-slate-900">Accent</h2>
                    <p class="mt-1 text-sm text-slate-500">#F59E0B — calls to action</p>
                </div>
                <div class="card-hover">
                    <div class="mb-3 h-2 w-12 rounded-full bg-surface-muted ring-1 ring-slate-200"></div>
                    <h2 class="font-semibold text-slate-900">Surface</h2>
                    <p class="mt-1 text-sm text-slate-500">#F8FAFC — background</p>
                </div>
            </div>

            <div class="mt-12 card">
                <h2 class="text-lg font-semibold text-slate-900">Stack verified</h2>
                <ul class="mt-4 grid gap-2 text-sm text-slate-600 sm:grid-cols-2">
                    <li>Laravel {{ app()->version() }}</li>
                    <li>Tailwind CSS v4</li>
                    <li>Alpine.js</li>
                    <li>Motion (animations)</li>
                    <li>ApexCharts</li>
                    <li>Notyf + SweetAlert2</li>
                    <li>Lucide Icons (ready)</li>
                    <li>Inter typography</li>
                </ul>
            </div>
        </main>
    </div>
</body>
</html>
