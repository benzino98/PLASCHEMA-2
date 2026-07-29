@props(['provider'])

<a href="{{ route('providers.show', $provider) }}" class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
    <div class="flex items-start justify-between gap-3">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-primary/10 transition group-hover:bg-primary/20">
            @if ($provider->photo)
                <img src="{{ asset('storage/' . $provider->photo) }}" alt="{{ $provider->name }}" class="h-full w-full rounded-xl object-cover">
            @else
                <i data-lucide="building-2" class="h-6 w-6 text-primary"></i>
            @endif
        </div>
        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $provider->accreditationColor() }}">
            {{ $provider->accreditationLabel() }}
        </span>
    </div>
    
    <div class="mt-4 flex-1">
        <h3 class="text-lg font-bold text-slate-900 transition group-hover:text-primary line-clamp-2" title="{{ $provider->name }}">
            {{ $provider->name }}
        </h3>
        
        <div class="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-sm text-slate-500">
            <span class="inline-flex items-center gap-1.5" title="LGA">
                <i data-lucide="map-pin" class="h-4 w-4 shrink-0 text-slate-400"></i>
                <span class="truncate max-w-[120px]">{{ $provider->lga }}</span>
            </span>
            @if($provider->specialty)
                <span class="inline-flex items-center gap-1.5" title="Specialty">
                    <i data-lucide="stethoscope" class="h-4 w-4 shrink-0 text-slate-400"></i>
                    <span class="truncate max-w-[120px]">{{ $provider->specialty }}</span>
                </span>
            @endif
        </div>
        
        <p class="mt-3 text-sm text-slate-600 line-clamp-2 leading-relaxed" title="{{ $provider->address }}">
            {{ $provider->address }}
        </p>
    </div>
    
    @if ($provider->services)
        <div class="mt-4 flex flex-wrap gap-1.5">
            @foreach (array_slice($provider->services, 0, 3) as $service)
                <span class="inline-flex items-center rounded-md bg-slate-50 border border-slate-100 px-2 py-1 text-[11px] font-medium text-slate-600">
                    {{ $service }}
                </span>
            @endforeach
            @if (count($provider->services) > 3)
                <span class="inline-flex items-center rounded-md bg-slate-50 border border-slate-100 px-2 py-1 text-[11px] font-medium text-slate-500">
                    +{{ count($provider->services) - 3 }} more
                </span>
            @endif
        </div>
    @endif
    
    <div class="mt-5 border-t border-slate-100 pt-4 flex items-center justify-between">
        <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
            View details <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1"></i>
        </span>
        @if ($provider->phone)
            <span class="inline-flex items-center gap-1.5 text-xs text-slate-400">
                <i data-lucide="phone" class="h-3.5 w-3.5"></i> Call
            </span>
        @endif
    </div>
</a>
