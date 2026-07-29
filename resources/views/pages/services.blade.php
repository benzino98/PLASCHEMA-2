@extends('layouts.app')

@section('title', 'Digital Services')
@section('meta_description', 'Access PLASCHEMA online enrollment, membership verification, premium payment, and citizen support portals.')

@section('content')
    {{-- Premium Hero --}}
    <section class="relative isolate overflow-hidden bg-slate-950 py-20 text-white sm:py-24 lg:py-28">
        <div class="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_20%_30%,rgba(11,143,77,.4),transparent_40%),radial-gradient(circle_at_80%_70%,rgba(30,136,229,.3),transparent_35%)]"></div>
        <div class="absolute inset-0 -z-10 opacity-[.06]" style="background-image:linear-gradient(rgba(255,255,255,.8) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.8) 1px,transparent 1px);background-size:48px 48px"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="text-sm text-white/60">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">Digital Services</span>
            </nav>
            <div class="mt-10 max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-emerald-200 backdrop-blur">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>Available Online
                </div>
                <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    Healthcare services,<br>
                    <span class="bg-gradient-to-r from-emerald-300 to-cyan-300 bg-clip-text text-transparent">right at your fingertips.</span>
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                    Enroll, verify your membership, make secure premium payments, or reach our support team — wherever you are.
                </p>
            </div>
        </div>
    </section>

    {{-- Services Grid --}}
    <x-section class="bg-white" padding="lg">
        <div class="mb-12 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-primary">Choose a Service</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">What would you like to do?</h2>
            </div>
            <p class="max-w-md text-sm leading-6 text-slate-500">These services open secure PLASCHEMA portals in a new tab. Your information remains protected throughout.</p>
        </div>
        <x-service-grid :services="$services" />
    </x-section>

    {{-- Trust & Security Section --}}
    <section class="bg-slate-50 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center mb-12">
                <p class="text-sm font-semibold uppercase tracking-wider text-primary">Peace of Mind</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Secure & Available 24/7</h2>
            </div>
            <div class="grid gap-8 md:grid-cols-3">
                <div class="flex flex-col items-center rounded-xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <i data-lucide="lock-keyhole" class="h-6 w-6"></i>
                    </div>
                    <h3 class="mt-4 font-semibold text-slate-900">Secure Portals</h3>
                    <p class="mt-2 text-sm text-slate-500">Every digital service uses encrypted connections to protect your personal and payment details.</p>
                </div>
                <div class="flex flex-col items-center rounded-xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-secondary/10 text-secondary">
                        <i data-lucide="clock-3" class="h-6 w-6"></i>
                    </div>
                    <h3 class="mt-4 font-semibold text-slate-900">Available Anytime</h3>
                    <p class="mt-2 text-sm text-slate-500">Access enrollment, verification, and payments online without visiting an office.</p>
                </div>
                <div class="flex flex-col items-center rounded-xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-500/10 text-rose-500">
                        <i data-lucide="life-buoy" class="h-6 w-6"></i>
                    </div>
                    <h3 class="mt-4 font-semibold text-slate-900">Need Assistance?</h3>
                    <p class="mt-2 text-sm text-slate-500">Our support team can help with portal access, membership, benefits, and providers.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <x-cta
        title="Have Questions?"
        description="If you're unsure about a service or need help with the portals, our team is ready to assist you."
        primary-label="Contact Support"
        :primary-url="route('contact')"
        variant="dark"
    />
@endsection
