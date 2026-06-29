@php
    $baseClass = $mobile
        ? 'block rounded-lg px-4 py-3 text-base font-medium transition'
        : 'rounded-lg px-3 py-2 text-sm font-medium transition';

    $activeClass = $mobile
        ? 'bg-primary-50 text-primary'
        : 'bg-primary-50 text-primary';

    $inactiveClass = $mobile
        ? 'text-slate-700 hover:bg-slate-50 hover:text-primary'
        : 'text-slate-600 hover:bg-slate-50 hover:text-primary';
@endphp

<a
    href="{{ $href() }}"
    class="{{ $baseClass }} {{ $isActive() ? $activeClass : $inactiveClass }}"
    @if ($isExternal()) target="_blank" rel="noopener noreferrer" @endif
    @if ($isActive()) aria-current="page" @endif
>
    {{ $item['label'] }}
    @if ($isExternal())
        <i data-lucide="external-link" class="{{ $mobile ? 'ml-1 inline h-3.5 w-3.5' : 'hidden' }}"></i>
    @endif
</a>
