@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- Hero --}}
    <section class="page-hero">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8 lg:py-28">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-sm font-semibold uppercase tracking-wider text-primary">Plateau State Healthcare</p>
                <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
                    Affordable Healthcare For Every
                    <span class="text-primary">Plateau Citizen</span>
                </h1>
                <p class="mt-6 text-lg leading-relaxed text-slate-600">
                    Enroll in PLASCHEMA, verify your membership, find accredited providers, and access quality healthcare across Plateau State.
                </p>
                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ config('plaschema.services.enrollment') }}" class="btn-primary" target="_blank" rel="noopener noreferrer">
                        <i data-lucide="user-plus" class="h-4 w-4"></i>
                        Enroll Now
                    </a>
                    <a href="{{ config('plaschema.services.verification') }}" class="btn-secondary" target="_blank" rel="noopener noreferrer">
                        <i data-lucide="shield-check" class="h-4 w-4"></i>
                        Verify Enrollment
                    </a>
                    <a href="{{ route('providers') }}" class="btn-outline">
                        <i data-lucide="map-pin" class="h-4 w-4"></i>
                        Find Hospital
                    </a>
                    <a href="{{ config('plaschema.services.payment') }}" class="btn-outline" target="_blank" rel="noopener noreferrer">
                        <i data-lucide="credit-card" class="h-4 w-4"></i>
                        Renew Membership
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Statistics --}}
    <x-section title="PLASCHEMA at a Glance" subtitle="Impact" centered class="bg-white">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <x-stat-card value="500K+" label="Enrolled Citizens" icon="users" trend="Growing every month" />
            <x-stat-card value="200+" label="Accredited Providers" icon="building-2" />
            <x-stat-card value="17" label="LGAs Covered" icon="map" />
            <x-stat-card value="24/7" label="Support Available" icon="headphones" />
        </div>
    </x-section>

    {{-- Health plans preview --}}
    <x-section title="Health Insurance Plans" subtitle="Coverage Options" centered class="bg-surface">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <x-plan-card
                name="Formal Sector"
                price="Employer-backed"
                description="For civil servants and organized private sector employees."
                :features="['Comprehensive outpatient care', 'Inpatient services', 'Maternity coverage', 'Annual health screening']"
            />
            <x-plan-card
                name="Informal Sector"
                price="From ₦12,000/yr"
                description="Flexible coverage for traders, artisans, and self-employed citizens."
                :features="['Primary healthcare access', 'Essential drugs', 'Emergency care', 'Referral services']"
                :highlighted="true"
            />
            <x-plan-card
                name="Family Plan"
                price="Per household"
                description="Protect your entire family under one affordable package."
                :features="['Spouse & children covered', 'Pediatric care', 'Immunization', 'Family planning']"
            />
        </div>
        <div class="mt-10 text-center">
            <a href="{{ route('health-plans') }}" class="btn-outline">View All Plans</a>
        </div>
    </x-section>

    {{-- FAQ preview --}}
    <x-section title="Frequently Asked Questions" subtitle="Help Center" centered class="bg-white">
        <div class="mx-auto max-w-3xl">
            <x-accordion :items="[
                ['question' => 'Who is eligible for PLASCHEMA?', 'answer' => 'All residents of Plateau State are eligible, including formal and informal sector workers, students, families, and vulnerable persons under the BHCPF equity program.'],
                ['question' => 'How do I enroll?', 'answer' => 'Visit our online enrollment portal, complete the registration form, choose your plan, and pay your premium. You can also visit any PLASCHEMA office for assistance.'],
                ['question' => 'How do I find an accredited hospital?', 'answer' => 'Use the Find Healthcare Provider page to search by LGA, specialty, or hospital name. You can also view providers on an interactive map.'],
            ]" />
        </div>
    </x-section>

    {{-- CTA --}}
    <x-cta
        title="Ready to Get Covered?"
        description="Join thousands of Plateau citizens already enjoying affordable, quality healthcare through PLASCHEMA."
        primary-label="Start Enrollment"
        :primary-url="config('plaschema.services.enrollment')"
        :primary-external="true"
        secondary-label="Contact Us"
        :secondary-url="route('contact')"
        variant="gradient"
    />
@endsection
