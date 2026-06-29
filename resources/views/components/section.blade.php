@props([
    'title' => null,
    'subtitle' => null,
    'centered' => false,
    'padding' => 'default',
])

@php
    $paddingClass = match ($padding) {
        'sm' => 'py-10 sm:py-12',
        'lg' => 'py-16 sm:py-20 lg:py-24',
        default => 'py-12 sm:py-16',
    };
@endphp

<section {{ $attributes->merge(['class' => $paddingClass]) }}>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if ($title || $subtitle)
            <div class="{{ $centered ? 'mx-auto max-w-3xl text-center' : 'max-w-3xl' }} mb-10">
                @if ($subtitle)
                    <p class="text-sm font-semibold uppercase tracking-wider text-primary">{{ $subtitle }}</p>
                @endif
                @if ($title)
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $title }}</h2>
                @endif
            </div>
        @endif
        {{ $slot }}
    </div>
</section>
