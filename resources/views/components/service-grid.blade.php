@props(['services', 'compact' => false])
<div class="grid gap-5 sm:grid-cols-2 {{ $compact ? 'lg:grid-cols-4' : 'lg:grid-cols-2' }}">
@foreach($services as $service)
@php
$styles = match($service['accent']) {
    'secondary' => ['bg'=>'from-cyan-50 to-blue-50','icon'=>'bg-secondary text-white','ring'=>'hover:border-secondary/30','glow'=>'bg-secondary/10'],
    'amber' => ['bg'=>'from-amber-50 to-orange-50','icon'=>'bg-amber-500 text-white','ring'=>'hover:border-amber-300','glow'=>'bg-amber-400/10'],
    'rose' => ['bg'=>'from-rose-50 to-pink-50','icon'=>'bg-rose-500 text-white','ring'=>'hover:border-rose-300','glow'=>'bg-rose-400/10'],
    default => ['bg'=>'from-emerald-50 to-teal-50','icon'=>'bg-primary text-white','ring'=>'hover:border-primary/30','glow'=>'bg-primary/10'],
};
@endphp
<a id="service-{{ $service['key'] }}" href="{{ $service['url'] }}" target="_blank" rel="noopener noreferrer" class="group relative isolate overflow-hidden rounded-2xl border border-slate-200 bg-gradient-to-br {{ $styles['bg'] }} p-6 shadow-sm transition duration-300 {{ $styles['ring'] }} hover:-translate-y-1 hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 {{ $compact ? '' : 'sm:p-8' }}">
    <div class="absolute -right-12 -top-12 -z-10 h-36 w-36 rounded-full {{ $styles['glow'] }} blur-2xl transition duration-500 group-hover:scale-150"></div>
    <div class="flex items-start justify-between gap-4"><div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl {{ $styles['icon'] }} shadow-lg"><i data-lucide="{{ $service['icon'] }}" class="h-6 w-6"></i></div><i data-lucide="arrow-up-right" class="h-5 w-5 text-slate-400 transition group-hover:-translate-y-1 group-hover:translate-x-1 group-hover:text-slate-700"></i></div>
    <p class="mt-6 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $service['eyebrow'] }}</p>
    <h3 class="mt-2 {{ $compact ? 'text-lg' : 'text-xl sm:text-2xl' }} font-bold text-slate-900">{{ $service['title'] }}</h3>
    <p class="mt-3 text-sm leading-6 text-slate-600">{{ $service['description'] }}</p>
    <span class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-slate-900">{{ $service['action'] }}<i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i></span>
    <span class="sr-only">Opens in a new tab</span>
</a>
@endforeach
</div>
