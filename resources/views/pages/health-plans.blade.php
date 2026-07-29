@extends('layouts.app')

@section('title', 'Health Insurance Plans')
@section('meta_description', 'Explore PLASCHEMA health insurance plans for formal, informal, family, student, and vulnerable persons coverage.')

@section('content')
    {{-- Premium Hero --}}
    <section class="relative isolate overflow-hidden bg-slate-950 py-20 text-white sm:py-24 lg:py-28">
        <div class="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_20%_30%,rgba(11,143,77,.4),transparent_40%),radial-gradient(circle_at_80%_70%,rgba(30,136,229,.3),transparent_35%)]"></div>
        <div class="absolute inset-0 -z-10 opacity-[.06]" style="background-image:linear-gradient(rgba(255,255,255,.8) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.8) 1px,transparent 1px);background-size:48px 48px"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="text-sm text-white/60">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">Health Plans</span>
            </nav>
            <div class="mt-10 max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-emerald-200 backdrop-blur">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>For Everyone
                </div>
                <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    Find the perfect<br>
                    <span class="bg-gradient-to-r from-emerald-300 to-cyan-300 bg-clip-text text-transparent">health plan for you.</span>
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                    Choose the plan that fits your needs — from formal sector employees to families, students, and vulnerable persons.
                </p>
            </div>
        </div>
    </section>

    {{-- Plan cards --}}
    <x-section class="bg-white" padding="lg">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach ($plans as $plan)
                <x-plan-card
                    :name="$plan->name"
                    :price="$plan->price_label"
                    :description="$plan->description"
                    :highlighted="$plan->is_featured"
                    :features="$plan->benefits->where('is_included', true)->take(4)->pluck('benefit_label')->all()"
                />
            @endforeach
        </div>
    </x-section>

    {{-- How to Enroll section --}}
    <section class="bg-slate-50 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center mb-12">
                <p class="text-sm font-semibold uppercase tracking-wider text-primary">Get Started</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">How to Enroll</h2>
                <p class="mt-4 text-slate-500">Simple steps to get covered by PLASCHEMA.</p>
            </div>
            <div class="grid gap-8 md:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-xl font-bold text-primary">1</div>
                    <h3 class="font-semibold text-slate-900">Choose Your Plan</h3>
                    <p class="mt-2 text-sm text-slate-500">Review the plans above and select the one that best suits your situation.</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-xl font-bold text-primary">2</div>
                    <h3 class="font-semibold text-slate-900">Register Online</h3>
                    <p class="mt-2 text-sm text-slate-500">Use our secure portal to provide your details and choose a primary healthcare provider.</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-xl font-bold text-primary">3</div>
                    <h3 class="font-semibold text-slate-900">Get Covered</h3>
                    <p class="mt-2 text-sm text-slate-500">Once approved, you'll receive your membership details and can access healthcare benefits.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Benefits Comparison Table --}}
    <x-section title="Benefits Comparison" subtitle="Compare All Plans" centered class="bg-white" padding="lg">
        <x-benefits-table :plans="$plans" :benefit-rows="$benefitRows" />
        <p class="mt-4 text-center text-xs text-slate-500">Scroll horizontally on mobile to compare all plans.</p>
    </x-section>

    {{-- FAQs for Plans --}}
    <x-section title="Frequently Asked Questions" subtitle="About Health Plans" class="bg-slate-50">
        <div class="mx-auto max-w-4xl">
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($faqs as $faq)
                    <div class="rounded-lg border border-slate-200 bg-white p-5">
                        <h3 class="font-semibold text-slate-800">{{ $faq->question }}</h3>
                        <p class="mt-2 text-sm text-slate-500">{{ $faq->answer }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </x-section>

    {{-- CTA --}}
    <x-cta
        title="Ready to Get Covered?"
        description="Enroll today and enjoy peace of mind with quality, affordable healthcare for you and your family."
        primary-label="Enroll Now"
        :primary-url="config('plaschema.services.enrollment')"
        :primary-external="true"
        secondary-label="Contact Us for Help"
        :secondary-url="route('contact')"
        variant="gradient"
    />
@endsection
