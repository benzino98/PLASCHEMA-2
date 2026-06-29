@extends('layouts.app')

@section('title', 'Health Insurance Plans')
@section('meta_description', 'Explore PLASCHEMA health insurance plans for formal, informal, family, student, and vulnerable persons coverage.')

@section('content')
    <div class="page-hero border-b border-slate-200/60">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[['label' => 'Health Plans']]" />
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Health Insurance Plans</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-600">
                Choose the plan that fits your needs — from formal sector employees to families, students, and vulnerable persons.
            </p>
        </div>
    </div>

  <x-section class="bg-white">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
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

    <x-section title="Benefits Comparison" subtitle="Compare Plans" centered class="bg-surface">
        <x-benefits-table :plans="$plans" :benefit-rows="$benefitRows" />
        <p class="mt-4 text-center text-xs text-slate-500">Scroll horizontally on mobile to compare all plans.</p>
    </x-section>

    <x-cta
        title="Find the Right Plan for You"
        description="Not sure which plan to choose? Contact us or start enrollment and our team will guide you."
        primary-label="Enroll Now"
        :primary-url="config('plaschema.services.enrollment')"
        :primary-external="true"
        secondary-label="Contact Us"
        :secondary-url="route('contact')"
    />
@endsection
