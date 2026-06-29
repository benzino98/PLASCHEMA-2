@props([
    'items' => [],
])

@if (count($items))
    <nav aria-label="Breadcrumb" {{ $attributes->merge(['class' => 'mb-6']) }}>
        <ol class="flex flex-wrap items-center gap-1.5 text-sm text-slate-500">
            <li>
                <a href="{{ route('home') }}" class="transition hover:text-primary">Home</a>
            </li>
            @foreach ($items as $item)
                <li class="flex items-center gap-1.5">
                    <i data-lucide="chevron-right" class="h-3.5 w-3.5 text-slate-300"></i>
                    @if ($loop->last)
                        <span class="font-medium text-slate-900" aria-current="page">{{ $item['label'] }}</span>
                    @elseif (isset($item['route']))
                        <a href="{{ route($item['route']) }}" class="transition hover:text-primary">{{ $item['label'] }}</a>
                    @elseif (isset($item['url']))
                        <a href="{{ $item['url'] }}" class="transition hover:text-primary">{{ $item['label'] }}</a>
                    @else
                        <span>{{ $item['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
