@props([
    'name',
    'price',
    'description' => null,
    'features' => [],
    'highlighted' => false,
    'ctaLabel' => 'Enroll Now',
    'ctaUrl' => null,
])

@php
    $ctaUrl = $ctaUrl ?? config('plaschema.services.enrollment');
@endphp

<div {{ $attributes->merge([
    'class' => 'relative flex flex-col rounded-[var(--radius-card)] border p-6 ' . ($highlighted ? 'border-primary bg-primary-50 shadow-lg ring-2 ring-primary' : 'border-slate-100 bg-white'),
]) }} style="{{ ! $highlighted ? 'box-shadow: var(--shadow-card)' : '' }}">
    @if ($highlighted)
        <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-accent px-3 py-0.5 text-xs font-semibold text-white">
            Popular
        </span>
    @endif

    <h3 class="text-lg font-semibold text-slate-900">{{ $name }}</h3>
    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $price }}</p>
    @if ($description)
        <p class="mt-2 text-sm text-slate-500">{{ $description }}</p>
    @endif

    @if (count($features))
        <ul class="mt-6 flex-1 space-y-2">
            @foreach ($features as $feature)
                <li class="flex items-start gap-2 text-sm text-slate-600">
                    <i data-lucide="check" class="mt-0.5 h-4 w-4 shrink-0 text-primary"></i>
                    {{ $feature }}
                </li>
            @endforeach
        </ul>
    @endif

    <a
        href="{{ $ctaUrl }}"
        class="{{ $highlighted ? 'btn-primary' : 'btn-outline' }} mt-6 w-full"
        target="_blank"
        rel="noopener noreferrer"
    >
        {{ $ctaLabel }}
    </a>
</div>
