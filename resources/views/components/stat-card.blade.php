@props([
    'value',
    'label',
    'icon' => null,
    'trend' => null,
])

<div {{ $attributes->merge(['class' => 'card text-center']) }}>
    @if ($icon)
        <div class="mx-auto mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-primary-50 text-primary">
            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
        </div>
    @endif
    <p class="text-3xl font-bold tracking-tight text-slate-900">{{ $value }}</p>
    <p class="mt-1 text-sm text-slate-500">{{ $label }}</p>
    @if ($trend)
        <p class="mt-2 text-xs font-medium text-primary">{{ $trend }}</p>
    @endif
</div>
