@props([
    'title',
    'description' => null,
    'primaryLabel' => 'Get Started',
    'primaryUrl' => '#',
    'secondaryLabel' => null,
    'secondaryUrl' => null,
    'primaryExternal' => false,
    'secondaryExternal' => false,
    'variant' => 'primary',
])

@php
    $bgClass = match ($variant) {
        'gradient' => 'bg-gradient-to-br from-primary to-secondary',
        'dark' => 'bg-slate-900',
        default => 'bg-primary',
    };
@endphp

<section class="{{ $bgClass }} relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/20"></div>
        <div class="absolute -bottom-16 -left-16 h-48 w-48 rounded-full bg-white/10"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-16 lg:px-8 lg:py-20">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ $title }}</h2>
            @if ($description)
                <p class="mt-4 text-lg text-white/85">{{ $description }}</p>
            @endif
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a
                    href="{{ $primaryUrl }}"
                    class="inline-flex items-center justify-center gap-2 rounded-[var(--radius-button)] bg-white px-6 py-3 text-sm font-semibold text-primary shadow-lg transition hover:bg-slate-50"
                    @if ($primaryExternal) target="_blank" rel="noopener noreferrer" @endif
                >
                    {{ $primaryLabel }}
                </a>
                @if ($secondaryLabel)
                    <a
                        href="{{ $secondaryUrl ?? '#' }}"
                        class="inline-flex items-center justify-center gap-2 rounded-[var(--radius-button)] border-2 border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:border-white hover:bg-white/10"
                        @if ($secondaryExternal) target="_blank" rel="noopener noreferrer" @endif
                    >
                        {{ $secondaryLabel }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
