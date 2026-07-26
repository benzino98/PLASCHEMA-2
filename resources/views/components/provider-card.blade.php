@props(['provider'])

<a href="{{ route('providers.show', $provider) }}" class="card-hover group flex flex-col">
    <div class="flex items-start justify-between gap-3">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-primary-50">
            <i data-lucide="building-2" class="h-5 w-5 text-primary"></i>
        </div>
        <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $provider->accreditationColor() }}">
            {{ $provider->accreditationLabel() }}
        </span>
    </div>
    <h3 class="mt-4 text-lg font-semibold text-slate-900 transition group-hover:text-primary">{{ $provider->name }}</h3>
    <p class="mt-1 text-sm text-slate-500">{{ $provider->lga }} &middot; {{ $provider->specialty }}</p>
    <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $provider->address }}</p>
    @if ($provider->services)
        <div class="mt-4 flex flex-wrap gap-1.5">
            @foreach (array_slice($provider->services, 0, 3) as $service)
                <span class="rounded-md bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $service }}</span>
            @endforeach
            @if (count($provider->services) > 3)
                <span class="rounded-md bg-slate-100 px-2 py-0.5 text-xs text-slate-500">+{{ count($provider->services) - 3 }}</span>
            @endif
        </div>
    @endif
    <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-primary">
        View details <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-0.5"></i>
    </span>
</a>
